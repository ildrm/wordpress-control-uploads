<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
use ContentFirewall\Domain\{Decision, FileDescriptor, Finding, Policy, State, UploadContext};
final class ScanRepository
{
    public function __construct(private \wpdb $db, private Tables $tables, private int $siteId) {}
    public function create(FileDescriptor $file, UploadContext $context, Policy $policy, string $privateKey): int
    {
        if ($context->siteId !== $this->siteId) { throw new \RuntimeException('SECURITY.TENANT'); }
        $now = gmdate('Y-m-d H:i:s');
        $ok = $this->db->insert($this->tables->name('scans'), ['site_id' => $this->siteId, 'correlation' => bin2hex(random_bytes(16)), 'user_id' => $context->userId, 'state' => State::Received->value, 'sha256' => $file->sha256, 'file_name' => $file->name, 'mime' => $file->mime, 'bytes' => $file->bytes, 'private_key' => $privateKey, 'policy_id' => $policy->id, 'policy_version' => $policy->version, 'context_json' => json_encode($context->signals(), JSON_THROW_ON_ERROR), 'signals_json' => '{}', 'decision_json' => '{}', 'created_at' => $now, 'updated_at' => $now, 'expires_at' => gmdate('Y-m-d H:i:s', time() + 7 * DAY_IN_SECONDS)]);
        if ($ok === false) { throw new \RuntimeException('DATABASE.SCAN_CREATE'); }
        return (int)$this->db->insert_id;
    }
    public function get(int $id): array
    {
        $row = $this->db->get_row($this->db->prepare('SELECT * FROM %i WHERE id=%d AND site_id=%d', $this->tables->name('scans'), $id, $this->siteId), ARRAY_A);
        if (!$row) { throw new \RuntimeException('DATABASE.NOT_FOUND'); }
        return $row;
    }
    public function lock(int $id, int $revision): array
    {
        $row = $this->db->get_row($this->db->prepare('SELECT * FROM %i WHERE id=%d AND site_id=%d FOR UPDATE', $this->tables->name('scans'), $id, $this->siteId), ARRAY_A);
        if (!$row || (int)$row['revision'] !== $revision) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        return $row;
    }
    public function transition(int $id, int $revision, State $to, array $extra = []): bool
    {
        $row = $this->get($id);
        if ((int)$row['revision'] !== $revision) { return false; }
        $from = State::from($row['state']);
        if (!$from->canTransition($to)) { throw new \RuntimeException('QUEUE.INVALID_TRANSITION'); }
        if ($from === $to && !$extra) { return true; }
        $allowed = ['decision_json', 'signals_json', 'risk', 'attachment_id', 'private_key', 'policy_id', 'policy_version'];
        if (array_diff(array_keys($extra), $allowed)) { throw new \RuntimeException('DATABASE.UPDATE_FIELDS'); }
        $changed = $this->db->update($this->tables->name('scans'), array_merge($extra, ['state' => $to->value, 'revision' => $revision + 1, 'updated_at' => gmdate('Y-m-d H:i:s')]), ['id' => $id, 'site_id' => $this->siteId, 'revision' => $revision]);
        if ($changed === false) { throw new \RuntimeException('DATABASE.TRANSITION'); }
        return $changed === 1;
    }
    /** @param list<Finding> $findings */
    public function complete(int $id, int $revision, State $state, Decision $decision, array $signals, array $findings, bool $fromQueue = false, ?callable $onComplete = null): bool
    {
        $this->db->query('START TRANSACTION');
        try {
            if ($fromQueue && $this->get($id)['state'] === State::Pending->value) {
                if (!$this->transition($id, $revision, State::Content)) { $this->db->query('ROLLBACK'); return false; } $revision++;
            }
            $ok = $this->transition($id, $revision, $state, ['decision_json' => json_encode($decision, JSON_THROW_ON_ERROR), 'signals_json' => json_encode($signals, JSON_THROW_ON_ERROR), 'risk' => $decision->risk]);
            if (!$ok) { $this->db->query('ROLLBACK'); return false; }
            if ($this->db->delete($this->tables->name('findings'), ['scan_id' => $id]) === false) { throw new \RuntimeException('DATABASE.FINDING'); }
            foreach ($findings as $finding) {
                if ($this->db->insert($this->tables->name('findings'), ['scan_id' => $id, 'category' => $finding->category, 'provider' => $finding->provider, 'model' => $finding->model, 'confidence' => $finding->confidence, 'payload' => json_encode($finding, JSON_THROW_ON_ERROR)]) === false) { throw new \RuntimeException('DATABASE.FINDING'); }
            }
            if (in_array($state, [State::Review, State::Quarantined, State::Failed, State::Blocked], true)) {
                $this->db->query($this->db->prepare("INSERT IGNORE INTO %i (scan_id,notes_json,sla_at) VALUES (%d,%s,%s)", $this->tables->name('cases'), $id, '[]', gmdate('Y-m-d H:i:s', time() + DAY_IN_SECONDS)));
            }
            if ($this->db->last_error) { throw new \RuntimeException('DATABASE.COMPLETE'); }
            if ($onComplete) { $onComplete(); }
            if ($this->db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } return true;
        } catch (\Throwable $e) { $this->db->query('ROLLBACK'); throw $e; }
    }
    public function queueRescan(int $id, int $revision, Policy $policy, callable $enqueue): void
    {
        $this->db->query('START TRANSACTION');
        try {
            if (!$this->transition($id, $revision, State::Content, ['policy_id' => $policy->id, 'policy_version' => $policy->version, 'signals_json' => '{}'])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $enqueue();
            if ($this->db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
        } catch (\Throwable $e) { $this->db->query('ROLLBACK'); throw $e; }
    }
    /** @return list<Finding> */
    public function findings(int $id): array
    {
        $this->get($id); $rows = $this->db->get_col($this->db->prepare('SELECT payload FROM %i WHERE scan_id=%d ORDER BY id LIMIT 512', $this->tables->name('findings'), $id));
        return array_map(static fn(string $p): Finding => Finding::fromArray(json_decode($p, true, 16, JSON_THROW_ON_ERROR)), $rows);
    }
    public function page(int $after = 0, int $limit = 30, string $state = '', int $owner = -1, int $userId = -1): array
    {
        $sql = 'SELECT s.id,s.correlation,s.attachment_id,s.user_id,s.state,s.revision,s.file_name,s.mime,s.bytes,s.policy_id,s.policy_version,s.risk,s.created_at,s.updated_at,c.owner_id,c.priority,c.sla_at FROM %i s LEFT JOIN %i c ON c.scan_id=s.id WHERE s.site_id=%d AND s.id>%d';
        $args = [$this->tables->name('scans'), $this->tables->name('cases'), $this->siteId, max(0, $after)];
        if ($state !== '') { State::from($state); $sql .= ' AND s.state=%s'; $args[] = $state; }
        if ($owner >= 0) { $sql .= ' AND c.owner_id=%d'; $args[] = $owner; }
        if ($userId >= 0) { $sql .= ' AND s.user_id=%d'; $args[] = $userId; }
        $sql .= ' ORDER BY s.id ASC LIMIT %d'; $args[] = min(100, max(1, $limit));
        return $this->db->get_results($this->db->prepare($sql, ...$args), ARRAY_A);
    }
    /** @param list<int> $attachmentIds @return array<int,array> */
    public function latestMany(array $attachmentIds): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $attachmentIds), static fn(int $id): bool => $id > 0)));
        if (!$ids) { return []; }
        if (count($ids) > 1000) { throw new \InvalidArgumentException('VALIDATION.MEDIA_LIMIT'); }
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));
        $sql = 'SELECT s.attachment_id,s.id,s.state,s.risk,s.policy_id,s.policy_version,s.updated_at FROM %i s JOIN (SELECT attachment_id,MAX(id) id FROM %i WHERE site_id=%d AND attachment_id IN (' . $placeholders . ') GROUP BY attachment_id) latest ON latest.id=s.id';
        $rows = $this->db->get_results($this->db->prepare($sql, $this->tables->name('scans'), $this->tables->name('scans'), $this->siteId, ...$ids), ARRAY_A);
        $result = []; foreach ($rows as $row) { $result[(int)$row['attachment_id']] = $row; } return $result;
    }
    public function latest(int $attachmentId): ?array
    {
        $row = $this->db->get_row($this->db->prepare('SELECT id,state,risk,policy_id,policy_version,updated_at FROM %i WHERE site_id=%d AND attachment_id=%d ORDER BY id DESC LIMIT 1', $this->tables->name('scans'), $this->siteId, $attachmentId), ARRAY_A); return $row ?: null;
    }
    public function associate(int $id, int $attachmentId): void
    {
        $this->get($id);
        if ($this->db->query($this->db->prepare('UPDATE %i SET attachment_id=%d WHERE site_id=%d AND id=%d AND attachment_id=0', $this->tables->name('scans'), $attachmentId, $this->siteId, $id)) === false) { throw new \RuntimeException('DATABASE.ATTACHMENT_LINK'); }
    }
    public function fingerprint(string $sha256): ?string { return $this->db->get_var($this->db->prepare('SELECT action FROM %i WHERE sha256=%s', $this->tables->name('fingerprints'), $sha256)); }
    public function addFingerprint(int $id, string $label): void
    {
        $scan = $this->get($id);
        $this->db->replace($this->tables->name('fingerprints'), ['sha256' => $scan['sha256'], 'action' => 'BLOCK', 'label' => mb_substr($label, 0, 160), 'created_at' => gmdate('Y-m-d H:i:s')]);
    }
}
