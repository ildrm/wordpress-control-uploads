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
        $rows = $this->s->db->get_results($this->s->db->prepare("SELECT id,revision,state,private_key FROM %i WHERE site_id=%d AND expires_at<UTC_TIMESTAMP() AND private_key<>'' ORDER BY expires_at LIMIT 100", $this->s->tables->name('scans'), $this->s->siteId), ARRAY_A); $count = 0;
        foreach ($rows as $row) {
            // Keep the scan summary after media expiry; its private original is no longer available.
            $target = in_array($row['state'], ['ALLOWED', 'SANITIZED'], true) ? State::from($row['state']) : State::Deleted;
            $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $row['id'];
            if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { continue; }
            $db->query('START TRANSACTION');
            try {
                if (!$this->s->scans->transition((int)$row['id'], (int)$row['revision'], $target, ['private_key' => ''])) { $db->query('ROLLBACK'); continue; }
                try { $this->s->storage->delete($row['private_key'], $this->s->siteId); }
                catch (\RuntimeException $e) { if ($e->getMessage() !== 'STORAGE.NOT_FOUND') { throw $e; } }
                $this->s->audit->record('retention.media_expired', (int)$row['id'], 0); $db->query('COMMIT'); $count++;
            } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
            finally { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
        }
        foreach (['cache' => 'expires_at', 'limits' => 'expires_at', 'events' => 'received_at'] as $table => $field) {
            $this->s->db->query($this->s->db->prepare('DELETE FROM %i WHERE %i < %s LIMIT 1000', $this->s->tables->name($table), $field, gmdate('Y-m-d H:i:s', $table === 'events' ? time() - DAY_IN_SECONDS : time())));
        }
        $this->s->db->query($this->s->db->prepare("DELETE FROM %i WHERE status='done' AND created_at<%s LIMIT 1000", $this->s->tables->name('jobs'), gmdate('Y-m-d H:i:s', time() - 7 * DAY_IN_SECONDS)));
        return $count;
    }
}
