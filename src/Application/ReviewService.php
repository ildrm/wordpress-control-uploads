<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, Decision, State};
final class ReviewService
{
    public function __construct(private Services $s) {}
    public function act(int $id, int $revision, string $action, string $reason, int $actorId, int $ownerId = 0, array $assignment = []): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        if (mb_strlen(trim($reason)) < 3 || mb_strlen(trim($reason)) > 2000) { throw new \InvalidArgumentException('VALIDATION.REASON'); }
        $assignment = CaseAssignment::parse($assignment); $row = $this->s->scans->get($id);
        if ((int)$row['metadata_erased'] === 1) { throw new \RuntimeException('STORAGE.METADATA_EXPIRED'); }
        if ((int)$row['revision'] !== $revision) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $before = json_decode($row['decision_json'], true, 16, JSON_THROW_ON_ERROR)['action'] ?? 'UNKNOWN';
        if ($action === 'approve') {
            (new Publisher($this->s))->publish($id, $revision, true, fn() => $this->record($id, $revision, $action, $reason, $actorId, $ownerId, $before));
            return ['id' => $id, 'state' => $this->s->scans->get($id)['state']];
        } elseif ($action === 'reject' || $action === 'quarantine' || $action === 'delete') {
            $state = match ($action) { 'reject' => State::Blocked, 'quarantine' => State::Quarantined, default => State::Deleted };
            $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $id;
            if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
            $db->query('START TRANSACTION');
            try {
            $this->s->scans->lock($id, $revision);
            if (!State::from($row['state'])->canTransition($state)) { throw new \RuntimeException('QUEUE.INVALID_TRANSITION'); }
            (new MediaWithdrawal($this->s))->withdraw((int)$row['attachment_id'], $id);
            $decision = new Decision($action === 'reject' ? Action::Block : Action::Quarantine, ['review.' . $action], [], $row['policy_id'], (int)$row['policy_version'], (float)$row['risk']);
            if (!$this->s->scans->transition($id, $revision, $state, ['decision_json' => json_encode($decision, JSON_THROW_ON_ERROR)])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $this->record($id, $revision, $action, $reason, $actorId, $ownerId, $before);
            if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
            } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
            finally { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
            if ($action === 'delete' && $row['private_key'] !== '') { $this->s->storage->delete($row['private_key'], $this->s->siteId); $this->s->scans->transition($id, $revision + 1, State::Deleted, ['private_key' => '']); }
            return ['id' => $id, 'state' => $state->value];
        } elseif ($action === 'rescan') {
            $this->s->scanner->rescan($id, $revision, fn() => $this->record($id, $revision, $action, $reason, $actorId, $ownerId, $before));
            return ['id' => $id, 'state' => $this->s->scans->get($id)['state']];
        }
        $db = $this->s->db; $db->query('START TRANSACTION');
        try {
        $this->s->scans->lock($id, $revision);
        if ($db->query($db->prepare('INSERT IGNORE INTO %i (scan_id,notes_json) VALUES (%d,%s)', $this->s->tables->name('cases'), $id, '[]')) === false) { throw new \RuntimeException('DATABASE.REVIEW_CASE'); }
        if ($action === 'fingerprint') { $this->s->scans->addFingerprint($id, $reason); }
        elseif ($action === 'assign') {
            if ($ownerId && (!user_can($ownerId, 'review_content_firewall_queue') || !is_user_member_of_blog($ownerId, $this->s->siteId))) { throw new \InvalidArgumentException('VALIDATION.OWNER'); }
            if ($this->s->db->update($this->s->tables->name('cases'), $assignment + ['owner_id' => $ownerId], ['scan_id' => $id]) === false) { throw new \RuntimeException('DATABASE.REVIEW_CASE'); }
        } elseif ($action === 'note' || $action === 'escalate') {
            if ($action === 'escalate') { if ($this->s->db->update($this->s->tables->name('cases'), ['priority' => 100], ['scan_id' => $id]) === false) { throw new \RuntimeException('DATABASE.REVIEW_CASE'); } }
        } else { throw new \InvalidArgumentException('VALIDATION.ACTION'); }
        if (!in_array($row['state'], ['RECEIVED', 'PREFLIGHT', 'SECURITY_SCANNING', 'CONTENT_SCANNING', 'PENDING_PROVIDER'], true) && !$this->s->scans->transition($id, $revision, State::from($row['state']), ['signals_json' => $row['signals_json']])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $this->record($id, $revision, $action, $reason, $actorId, $ownerId, $before);
        if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
        } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
        return ['id' => $id, 'state' => $this->s->scans->get($id)['state']];
    }
    public function escalateDue(): int
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $rows = $this->s->db->get_results($this->s->db->prepare("SELECT s.id,s.revision FROM %i c JOIN %i s ON s.id=c.scan_id WHERE s.site_id=%d AND c.priority<100 AND c.sla_at<UTC_TIMESTAMP() AND s.state IN ('REVIEW_REQUIRED','QUARANTINED','APPEALED','FAILED') AND s.metadata_erased=0 ORDER BY c.sla_at,c.scan_id LIMIT 100", $this->s->tables->name('cases'), $this->s->tables->name('scans'), $this->s->siteId), ARRAY_A); $count = 0;
        foreach ($rows as $row) { try { $this->act((int)$row['id'], (int)$row['revision'], 'escalate', 'Configured review deadline exceeded.', 0); $count++; } catch (\RuntimeException $e) { if ($e->getMessage() !== 'QUEUE.STALE_RESULT') { throw $e; } } }
        return $count;
    }
    private function record(int $id, int $revision, string $action, string $reason, int $actorId, int $ownerId, string $before): void
    {
        $this->s->audit->record('review.' . $action, $id, $actorId, ['revision' => $revision, 'owner_id' => $ownerId, 'reason_code' => 'moderator_supplied']);
        // Append-only rows prevent concurrent moderator notes from overwriting each other.
        if ($this->s->db->insert($this->s->tables->name('case_notes'), ['scan_id' => $id, 'actor_id' => $actorId, 'action' => $action, 'reason' => sanitize_textarea_field($reason), 'created_at' => gmdate('Y-m-d H:i:s')]) === false) { throw new \RuntimeException('DATABASE.REVIEW_NOTE'); }
        if (in_array($action, ['approve', 'reject'], true)) {
            foreach ($this->s->scans->findings($id) as $finding) { if ($this->s->db->insert($this->s->tables->name('evaluations'), ['scan_id' => $id, 'category' => $finding->category, 'predicted' => $before, 'observed' => $action === 'approve' ? 'ALLOW' : 'BLOCK', 'provider' => $finding->provider, 'model' => $finding->model, 'actor_id' => $actorId, 'created_at' => gmdate('Y-m-d H:i:s')]) === false) { throw new \RuntimeException('DATABASE.EVALUATION'); } }
            if ($this->s->db->query($this->s->db->prepare("UPDATE %i SET status='resolved',reviewer_id=%d,resolution=%s,resolved_at=UTC_TIMESTAMP() WHERE scan_id=%d AND status='pending'", $this->s->tables->name('appeals'), $actorId, sanitize_textarea_field($reason), $id)) === false) { throw new \RuntimeException('DATABASE.APPEAL'); }
        }
    }
    public function appeal(int $id, string $reason, int $userId): void
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $row = $this->s->scans->get($id);
        if ((int)$row['user_id'] !== $userId || $userId < 1 || mb_strlen(trim($reason)) < 3 || mb_strlen(trim($reason)) > 2000 || !in_array($row['state'], ['BLOCKED', 'QUARANTINED', 'REVIEW_REQUIRED'], true)) { throw new \RuntimeException('SECURITY.APPEAL_DENIED'); }
        $db = $this->s->db; $db->query('START TRANSACTION');
        try {
            if (!$this->s->scans->transition($id, (int)$row['revision'], State::Appealed)) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            if ($db->insert($this->s->tables->name('appeals'), ['scan_id' => $id, 'user_id' => $userId, 'reason' => sanitize_textarea_field($reason), 'resolution' => '', 'created_at' => gmdate('Y-m-d H:i:s')]) === false) { throw new \RuntimeException('DATABASE.APPEAL'); }
            $this->s->audit->record('review.appeal', $id, $userId); if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
        } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
    }
}
