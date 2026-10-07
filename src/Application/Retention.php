<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\State;
final class Retention
{
    public function __construct(private Services $s) {}
    public function run(): int
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $rows = $this->s->db->get_results($this->s->db->prepare("SELECT id,revision,state,private_key,attachment_id FROM %i WHERE site_id=%d AND expires_at<UTC_TIMESTAMP() AND private_key<>'' ORDER BY expires_at LIMIT 100", $this->s->tables->name('scans'), $this->s->siteId), ARRAY_A); $count = 0;
        $this->checkRead();
        foreach ($rows as $row) {
            // Keep the scan summary after media expiry; its private original is no longer available.
            $target = in_array($row['state'], ['ALLOWED', 'SANITIZED'], true) ? State::from($row['state']) : State::Deleted;
            $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $row['id'];
            if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { continue; }
            if ($db->query('START TRANSACTION') === false) { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); throw new \RuntimeException('DATABASE.RETENTION'); }
            try {
                if (!$this->s->scans->transition((int)$row['id'], (int)$row['revision'], $target, ['private_key' => ''])) { $db->query('ROLLBACK'); continue; }
                if ($target === State::Deleted && (int)$row['attachment_id'] && (int)($this->s->scans->latest((int)$row['attachment_id'])['id'] ?? 0) === (int)$row['id']) { (new MediaWithdrawal($this->s))->withdraw((int)$row['attachment_id'], (int)$row['id']); }
                try { $this->s->storage->delete($row['private_key'], $this->s->siteId); }
                catch (\RuntimeException $e) { if ($e->getMessage() !== 'STORAGE.NOT_FOUND') { throw $e; } }
                $this->s->audit->record('retention.media_expired', (int)$row['id'], 0); if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $count++;
            } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
            finally { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
        }
        $days = $this->s->settings['retention'];
        $metadata = $this->s->db->get_col($this->s->db->prepare("SELECT id FROM %i WHERE site_id=%d AND metadata_erased=0 AND ((state IN ('ALLOWED','SANITIZED') AND created_at<%s) OR (state NOT IN ('ALLOWED','SANITIZED') AND created_at<%s)) ORDER BY created_at,id LIMIT 100", $this->s->tables->name('scans'), $this->s->siteId, gmdate('Y-m-d H:i:s', time() - $days['safe_metadata_days'] * DAY_IN_SECONDS), gmdate('Y-m-d H:i:s', time() - $days['blocked_metadata_days'] * DAY_IN_SECONDS)));
        $this->checkRead();
        foreach ($metadata as $id) { (new \ContentFirewall\Privacy\RecordLifecycle($this->s))->eraseScan((int)$id, true); }
        foreach (['cache' => 'expires_at', 'limits' => 'expires_at', 'events' => 'received_at'] as $table => $field) {
            if ($this->s->db->query($this->s->db->prepare('DELETE FROM %i WHERE %i < %s LIMIT 1000', $this->s->tables->name($table), $field, gmdate('Y-m-d H:i:s', $table === 'events' ? time() - DAY_IN_SECONDS : time()))) === false) { throw new \RuntimeException('DATABASE.RETENTION'); }
        }
        foreach (['audit' => $days['audit_days'], 'evaluations' => $days['analytics_days']] as $table => $maximum) {
            if ($this->s->db->query($this->s->db->prepare('DELETE FROM %i WHERE created_at<%s LIMIT 1000', $this->s->tables->name($table), gmdate('Y-m-d H:i:s', time() - $maximum * DAY_IN_SECONDS))) === false) { throw new \RuntimeException('DATABASE.RETENTION'); }
        }
        if ($this->s->db->query($this->s->db->prepare('DELETE FROM %i WHERE day<%s LIMIT 1000', $this->s->tables->name('usage'), gmdate('Y-m-d', time() - $days['analytics_days'] * DAY_IN_SECONDS))) === false) { throw new \RuntimeException('DATABASE.RETENTION'); }
        if ($this->s->db->query($this->s->db->prepare("DELETE FROM %i WHERE status IN ('done','dead') AND created_at<%s LIMIT 1000", $this->s->tables->name('jobs'), gmdate('Y-m-d H:i:s', time() - $days['job_days'] * DAY_IN_SECONDS))) === false) { throw new \RuntimeException('DATABASE.RETENTION'); }
        if ($count > 0 && count($rows) === 100) { $last = end($rows); $this->s->jobs->enqueue('retention', [], 'retention:after:' . $last['id']); }
        if (count($metadata) === 100) { $this->s->jobs->enqueue('retention', [], 'retention:metadata:' . end($metadata)); }
        return $count;
    }
    /** @phpstan-impure wpdb read operations change last_error. */
    private function checkRead(): void { if ($this->s->db->last_error) { throw new \RuntimeException('DATABASE.RETENTION'); } }
}
