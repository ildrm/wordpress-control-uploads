<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Domain\{Action, Decision, FileDescriptor, Finding, Policy, ProviderResult, State, UploadContext};
use ContentFirewall\Persistence\{AuditRepository, PolicyRepository, ScanRepository};
use ContentFirewall\Security\{FileInspector, PrivateStorage};
use ContentFirewall\Media\ImageProcessor;
use ContentFirewall\Privacy\{TextInspector, QrInspector};
use ContentFirewall\Providers\Router;
use ContentFirewall\Policy\Engine;
final class ScanService
{
    public function __construct(private FileInspector $inspector, private SecurityPipeline $security, private PrivateStorage $storage, private ScanRepository $scans, private PolicyRepository $policies, private AuditRepository $audit, private Router $router, private \ContentFirewall\Queue\JobRepository $jobs, private int $siteId) {}
    /** @return array{id:int,decision:Decision} */
    public function receive(string $path, string $name, string $declared, UploadContext $context): array
    {
        $file = $this->inspector->inspect($path, $name, $declared); $policy = $this->policies->active();
        $key = $this->storage->put($path, $this->siteId, $file->sha256);
        try { $id = $this->scans->create($file, $context, $policy, $key); }
        catch (\Throwable $e) { $this->storage->delete($key, $this->siteId); throw $e; }
        $this->audit->record('upload.received', $id, $context->userId, ['policy' => $policy->id, 'version' => $policy->version]);
        $this->move($id, State::Preflight); $this->move($id, State::Security);
        // Scan the immutable private snapshot, not the caller's subsequently mutable file.
        $privateFile = $this->inspector->inspect($this->storage->path($key, $this->siteId), $name, $declared);
        try { $findings = $this->security->inspect($privateFile); }
        catch (\Throwable $e) {
            $code = self::errorCode($e); $decision = new Decision(Action::Quarantine, [$code], [], $policy->id, $policy->version, 1);
            $this->scans->complete($id, 2, State::Quarantined, $decision, $context->signals() + $file->signals(), []);
            $this->audit->record('security.failure', $id, 0, ['code' => $code]); return ['id' => $id, 'decision' => $decision];
        }
        $this->move($id, State::Content);
        $fingerprint = $this->scans->fingerprint($file->sha256);
        if ($fingerprint === 'BLOCK') { $findings[] = new Finding('fingerprint.blocked', 1, 'local', '1', false, 'deterministic'); }
        $signals = $context->signals() + $file->signals();
        $decision = (new Engine())->decide($policy, $signals, $findings);
        if ($fingerprint === 'BLOCK' && !array_filter($findings, static fn(Finding $f): bool => $f->hardSecurity)) { $decision = new Decision(Action::Block, ['fingerprint.blocked'], [], $policy->id, $policy->version, 1, $policy->shadow); }
        if ($decision->action === Action::Block && !$decision->shadow) { $this->finish($id, $decision, $signals, $findings); return ['id' => $id, 'decision' => $decision]; }
        $async = ($policy->options['requires_content'] ?? false) || str_starts_with($file->mime, 'video/') || str_starts_with($file->mime, 'audio/');
        if ($async) {
            $decision = new Decision(Action::Quarantine, ['scan.pending'], [], $policy->id, $policy->version, 0);
            if (!$this->scans->complete($id, 3, State::Pending, $decision, $signals, $findings, onComplete: fn() => $this->jobs->enqueue('scan', ['scan_id' => $id, 'revision' => 4], 'scan:' . $id . ':4'))) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        } else {
            if ($decision->action !== Action::Block && array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            $this->finish($id, $decision, $signals, $findings);
        }
        return ['id' => $id, 'decision' => $decision];
    }
    public function process(int $id, int $expectedRevision): Decision
    {
        $row = $this->scans->get($id);
        if ((int)$row['revision'] !== $expectedRevision) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $policy = $this->policies->get($row['policy_id'], (int)$row['policy_version']);
        $file = $this->inspector->inspect($this->storage->path($row['private_key'], $this->siteId), $row['file_name'], $row['mime']);
        if (!hash_equals($row['sha256'], $file->sha256)) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        if (!in_array($row['state'], [State::Pending->value, State::Content->value], true)) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $findings = $this->security->inspect($file); $signals = json_decode($row['context_json'], true, 16, JSON_THROW_ON_ERROR) + $file->signals();
        $signals['queue_revision'] = $expectedRevision;
        if ($this->scans->fingerprint($file->sha256) === 'BLOCK') { $findings[] = new Finding('fingerprint.blocked', 1, 'local', '1', false, 'deterministic'); }
        $decision = (new Engine())->decide($policy, $signals, $findings);
        if (array_filter($findings, static fn(Finding $f): bool => $f->hardSecurity || $f->category === 'fingerprint.blocked')) {
            if ($decision->action !== Action::Block) { $decision = new Decision(Action::Block, ['fingerprint.blocked'], [], $policy->id, $policy->version, 1, $policy->shadow); }
            $this->finish($id, $decision, $signals, $findings, $expectedRevision, true); return $decision;
        }
        if (!($policy->options['requires_content'] ?? false) && !str_starts_with($file->mime, 'audio/') && !str_starts_with($file->mime, 'video/')) {
            if (array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            $this->finish($id, $decision, $signals, $findings, $expectedRevision, true); return $decision;
        }
        $derivative = null;
        try {
            $prepared = $file;
            if ($file->width > 0) {
                $derivative = $this->storage->temporary($this->siteId); (new ImageProcessor())->reencode($file, $derivative);
                $prepared = $this->inspector->inspect($derivative, $file->name, $file->mime);
            }
            $results = $this->router->scan($prepared, $policy, $id); $ok = 0; $textMissing = (bool)($policy->options['requires_text'] ?? false); $providerScores = [];
            foreach ($results as $result) {
                if ($result->error) { continue; } $ok++; $findings = array_merge($findings, $result->findings);
                $findings = array_merge($findings, (new TextInspector())->inspect($result->text, $policy->options['patterns'] ?? []), (new QrInspector())->inspect($result->codes, $policy->options['qr_mode'] ?? 'review', $policy->options['domains'] ?? []));
                foreach ($result->findings as $finding) { $providerScores[$finding->category][$finding->scale][$finding->provider] = $finding->confidence; }
                // Sensitive extracted text exists only during evaluation, never in persistence/audit.
                if ($result->text !== '') {
                    $signals['ocr_text'] = $result->text;
                    if ($policy->options['requires_text'] ?? false) {
                        $moderated = $this->router->text($result->text, $id, $policy);
                        if (!$moderated->error) { $textMissing = false; $findings = array_merge($findings, $moderated->findings); }
                    }
                }
            }
            $decision = (new Engine())->decide($policy, $signals, $findings);
            if ($ok && $decision->action->publishable() && \ContentFirewall\Policy\EvidenceCoverage::missing($policy, $findings, $signals)) { $decision = new Decision(Action::Review, ['provider.coverage_incomplete'], [], $policy->id, $policy->version, $decision->risk, $policy->shadow); }
            if ($textMissing && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.text_unavailable'], [], $policy->id, $policy->version, 0, $policy->shadow); }
            if (!$ok && $decision->action !== Action::Block) { $decision = new Decision(match ($policy->options['failure_mode'] ?? 'QUARANTINE') { 'FAIL_OPEN' => Action::Allow, 'FAIL_CLOSED' => Action::Block, default => Action::Quarantine }, ['provider.unavailable'], [], $policy->id, $policy->version, 0); }
            if (($policy->options['consensus'] ?? false) && $ok < 2 && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.consensus_incomplete'], [], $policy->id, $policy->version, 0, $policy->shadow); }
            foreach ($providerScores as $scales) { $scores = $scales['probability'] ?? []; if (count($scores) > 1 && max($scores) - min($scores) > 0.35 && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.disagreement'], [], $policy->id, $policy->version, max($scores), $policy->shadow); } }
            if ($decision->action !== Action::Block && array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            unset($signals['ocr_text']); $this->finish($id, $decision, $signals, $findings, $expectedRevision, true);
            return $decision;
        } finally { if ($derivative && is_file($derivative)) { unlink($derivative); } }
    }
    public function rescan(int $id, ?int $expectedRevision = null): void
    {
        $row = $this->scans->get($id); $revision = $expectedRevision ?? (int)$row['revision'];
        if ((int)$row['revision'] !== $revision || $row['private_key'] === '') { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $policy = $this->policies->active();
        $this->scans->queueRescan($id, $revision, $policy, fn() => $this->jobs->enqueue('rescan', ['scan_id' => $id, 'revision' => $revision + 1], 'rescan:' . $id . ':' . ($revision + 1)));
    }
    private function move(int $id, State $to): void
    {
        $row = $this->scans->get($id); if (!$this->scans->transition($id, (int)$row['revision'], $to)) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $this->audit->record('scan.transition', $id, 0, ['state' => $to->value, 'revision' => (int)$row['revision'] + 1]);
    }
    private function finish(int $id, Decision $decision, array $signals, array $findings, ?int $expectedRevision = null, bool $fromQueue = false): void
    {
        $row = $this->scans->get($id); $enforced = $decision->shadow ? Action::Allow : $decision->action;
        $state = match ($enforced) { Action::Allow => State::Allowed, Action::Sanitize => State::Sanitizing, Action::Review => State::Review, Action::Quarantine => State::Quarantined, Action::Block => State::Blocked };
        if (!$this->scans->complete($id, $expectedRevision ?? (int)$row['revision'], $state, $decision, $signals, $findings, $fromQueue)) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $this->audit->record('scan.decision', $id, 0, ['action' => $decision->action->value, 'policy' => $decision->policyId, 'version' => $decision->policyVersion, 'shadow' => $decision->shadow]);
        do_action('cf_scan_completed', $id, $decision);
    }
    public static function errorCode(\Throwable $e): string { return preg_match('/^[A-Z]+\.[A-Z_]+$/D', $e->getMessage()) ? $e->getMessage() : 'CONFIGURATION.INTERNAL'; }
}
