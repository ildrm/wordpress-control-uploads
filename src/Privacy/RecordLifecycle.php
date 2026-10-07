<?php
declare(strict_types=1);
namespace ContentFirewall\Privacy;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Application\{MediaJournal, MediaWithdrawal};

/** Erase private material and metadata while retaining the minimal publication state. */
final class RecordLifecycle
{
    public function __construct(private Services $s) {}

    public function eraseScan(int $id, bool $retainAudit): bool
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $id;
        if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
        try {
            $journal = new MediaJournal($this->s);
            if ($journal->read('publish', $id) !== null && $journal->recover(1, $id)['failed']) { throw new \RuntimeException('STORAGE.JOURNAL'); }
            if ($db->query('START TRANSACTION') === false) { throw new \RuntimeException('DATABASE.ERASURE'); }
            try {
                $before = $this->s->scans->get($id); $row = $this->s->scans->lock($id, (int)$before['revision']);
                if ((int)$row['metadata_erased'] === 1) { $db->query('ROLLBACK'); return false; }
                $accepted = in_array($row['state'], ['ALLOWED', 'SANITIZED'], true);
                if (!$accepted && (int)$row['attachment_id'] && (int)($this->s->scans->latest((int)$row['attachment_id'])['id'] ?? 0) === $id) { (new MediaWithdrawal($this->s))->withdraw((int)$row['attachment_id'], $id); }
                if ($row['private_key'] !== '') {
                    try { $this->s->storage->delete($row['private_key'], $this->s->siteId); }
                    catch (\RuntimeException $e) { if ($e->getMessage() !== 'STORAGE.NOT_FOUND') { throw $e; } }
                }
                foreach (['findings', 'cases', 'case_notes', 'appeals', 'evaluations'] as $table) { $this->checked($db->delete($this->s->tables->name($table), ['scan_id' => $id])); }
                // Workers still holding an earlier revision cannot commit after this revision advance.
                $this->checked($db->query($db->prepare("DELETE FROM %i WHERE site_id=%d AND kind IN ('scan','rescan','webhook') AND JSON_UNQUOTE(JSON_EXTRACT(payload,'$.scan_id'))=%s", $this->s->tables->name('jobs'), $this->s->siteId, (string)$id)));
                if (!$retainAudit) { $this->checked($db->delete($this->s->tables->name('audit'), ['site_id' => $this->s->siteId, 'object_id' => $id])); }
                $this->checked($db->update($this->s->tables->name('scans'), [
                    'user_id' => 0, 'private_key' => '', 'metadata_erased' => 1, 'sha256' => str_repeat('0', 64), 'file_name' => '', 'mime' => '', 'bytes' => 0, 'risk' => 0,
                    'policy_id' => '', 'policy_version' => 0, 'context_json' => '{}', 'signals_json' => '{}', 'decision_json' => '{}',
                    'state' => $accepted ? $row['state'] : 'DELETED', 'revision' => (int)$row['revision'] + 1, 'updated_at' => gmdate('Y-m-d H:i:s'),
                ], ['id' => $id, 'site_id' => $this->s->siteId, 'revision' => (int)$row['revision']]));
                if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
                return true;
            } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
        } finally { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    }

    private function checked(int|bool $result): void
    {
        if ($result === false) { throw new \RuntimeException('DATABASE.ERASURE'); }
    }
}
