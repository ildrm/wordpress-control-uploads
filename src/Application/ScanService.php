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
    private ?\Closure $onDecision;
    /** @param null|callable(int,Decision):void $onDecision Transactional internal outbox callback. */
    public function __construct(private FileInspector $inspector, private SecurityPipeline $security, private PrivateStorage $storage, private ScanRepository $scans, private PolicyRepository $policies, private AuditRepository $audit, private Router $router, private \ContentFirewall\Queue\JobRepository $jobs, private int $siteId, ?callable $onDecision = null, private ?\ContentFirewall\Media\DocumentMedia $documents = null, private ?\ContentFirewall\Media\TemporalMedia $temporal = null, private ?\ContentFirewall\Authenticity\ContentCredentials $credentials = null) { $this->onDecision = $onDecision === null ? null : \Closure::fromCallable($onDecision); }
    /** @return array{id:int,decision:Decision} */
    public function receive(string $path, string $name, string $declared, UploadContext $context): array
    {
        if ($this->siteId !== get_current_blog_id() || $context->siteId !== $this->siteId) { throw new \RuntimeException('SECURITY.TENANT'); }
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
            $decision = $this->finish($id, $decision, $context->signals() + $file->signals(), [], 2);
            $this->audit->record('security.failure', $id, 0, ['code' => $code]); return ['id' => $id, 'decision' => $decision];
        }
        $this->move($id, State::Content);
        $fingerprint = $this->scans->fingerprint($file->sha256);
        if ($fingerprint === 'BLOCK') { $findings[] = new Finding('fingerprint.blocked', 1, 'local', '1', false, 'deterministic'); }
        $signals = $context->signals() + $file->signals();
        $decision = (new Engine())->decide($policy, $signals, $findings);
        if ($fingerprint === 'BLOCK' && !array_filter($findings, static fn(Finding $f): bool => $f->hardSecurity)) { $decision = new Decision(Action::Block, ['fingerprint.blocked'], [], $policy->id, $policy->version, 1, $policy->shadow); }
        if ($decision->action === Action::Block && !$decision->shadow) { $decision = $this->finish($id, $decision, $signals, $findings); return ['id' => $id, 'decision' => $decision]; }
        $async = $context->source === 'headless' || ($policy->options['requires_content'] ?? false) || str_starts_with($file->mime, 'video/') || str_starts_with($file->mime, 'audio/') || ($this->documents && $file->mime === 'application/pdf') || $this->credentials !== null;
        if ($async) {
            $decision = new Decision(Action::Quarantine, ['scan.pending'], [], $policy->id, $policy->version, 0);
            if (!$this->scans->complete($id, 3, State::Pending, $decision, $signals, $findings, onComplete: fn() => $this->jobs->enqueue('scan', ['scan_id' => $id, 'revision' => 4], 'scan:' . $id . ':4'))) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        } else {
            if ($decision->action !== Action::Block && array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            $decision = $this->finish($id, $decision, $signals, $findings);
        }
        return ['id' => $id, 'decision' => $decision];
    }
    public function process(int $id, int $expectedRevision): Decision
    {
        if ($this->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $row = $this->scans->get($id);
        if ((int)$row['revision'] !== $expectedRevision) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        if ($row['expires_at'] <= gmdate('Y-m-d H:i:s')) { throw new \RuntimeException('STORAGE.EXPIRED'); }
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
            $decision = $this->finish($id, $decision, $signals, $findings, $expectedRevision, true); return $decision;
        }
        $analysis = $this->evaluateFile($file, $policy, $signals, $findings, $id);
        return $this->finish($id, $analysis['decision'], $analysis['signals'], $analysis['findings'], $expectedRevision, true);
    }
    /** Ephemeral analysis only: never create a scan, attachment or publication job. @return array{decision:Decision,signals:array,findings:array,results:array} */
    public function evaluateFile(FileDescriptor $file, Policy $policy, array $signals, array $findings, int $id = 0): array
    {
        if ($this->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $decision = (new Engine())->decide($policy, $signals, $findings);
        if ($this->credentials) { $provenance = $this->credentials->inspect($file); $findings = array_merge($findings, $provenance['findings']); $signals['provenance'] = $provenance['report']; }
        $localProvenance = $this->credentials && \ContentFirewall\Policy\EvidenceCoverage::requiresOnlyProvenance($policy);
        if ($localProvenance) { $decision = (new Engine())->decide($policy, $signals, $findings); }
        if ((!($policy->options['requires_content'] ?? false) || $localProvenance) && !str_starts_with($file->mime, 'audio/') && !str_starts_with($file->mime, 'video/') && !($this->documents && $file->mime === 'application/pdf')) {
            if (array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            return ['decision' => $decision, 'signals' => $signals, 'findings' => $findings, 'results' => []];
        }
        $derivative = null;
        try {
            $prepared = $file;
            if ($file->width > 0) {
                $derivative = $this->storage->temporary($this->siteId); (new ImageProcessor())->reencode($file, $derivative);
                $prepared = $this->inspector->inspect($derivative, $file->name, $file->mime);
            }
            if ($this->documents && $file->mime === 'application/pdf') {
                $mediaPolicy = $localProvenance ? new Policy($policy->id, $policy->version, $policy->name, [], options: ['requires_content' => false]) : $policy;
                $media = $this->documents->inspect($file, $mediaPolicy, fn(FileDescriptor $part): array => $this->router->scan($part, $policy, $id, $findings, $signals), $findings, $signals); $results = $media['results']; $signals += $media['signals'];
                $findings = array_values(array_filter($findings, static fn(Finding $f): bool => $f->category !== 'security.requires_document_cdr'));
            } elseif ($this->temporal && (str_starts_with($file->mime, 'audio/') || str_starts_with($file->mime, 'video/'))) {
                $mediaPolicy = $localProvenance ? new Policy($policy->id, $policy->version, $policy->name, [], options: ['requires_content' => false]) : $policy;
                $media = $this->temporal->inspect($file, $mediaPolicy, fn(FileDescriptor $part): array => $this->router->scan($part, $policy, $id, $findings, $signals), $findings, $signals); $results = $media['results']; $signals = array_merge($signals, $media['signals']);
            } else { $results = $file->mime === 'text/plain' ? [new ProviderResult('local-text', '1', [], text: $this->text($file))] : $this->router->scan($prepared, $policy, $id, $findings, $signals); }
            $ok = 0; $identities = []; $textMissing = (bool)($policy->options['requires_text'] ?? false); $providerScores = []; $texts = [];
            foreach ($results as $result) {
                if ($result->error) { continue; } $ok++; if (!str_starts_with($result->provider, 'local-')) { $identities[$result->provider] = true; } $findings = array_merge($findings, $result->findings);
                if ($result->language !== '') { $signals['languages'] = array_values(array_unique(array_merge($signals['languages'] ?? [], [$result->language]))); }
                if ($result->text !== '') { $findings = array_merge($findings, (new TextInspector())->inspect($result->text, $policy->options['patterns'] ?? [])); }
                $findings = array_merge($findings, (new QrInspector())->inspect($result->codes, $policy->options['qr_mode'] ?? 'review', $policy->options['domains'] ?? []));
                foreach ($result->findings as $finding) { $providerScores[$finding->category][$finding->scale][$finding->provider] = $finding->confidence; }
                // Sensitive extracted text exists only during evaluation, never in persistence/audit.
                if ($result->text !== '') {
                    $texts[$result->text] = true;
                    $signals['ocr_text'] = implode("\n", array_keys($texts));
                    if (strlen($signals['ocr_text']) > 65536) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
                    if ($policy->options['requires_text'] ?? false) {
                        $moderated = $this->router->text($result->text, $id, $policy);
                        if (!$moderated->error) { $textMissing = false; $findings = array_merge($findings, $moderated->findings); }
                    }
                }
            }
            if (count($findings) > 512) { throw new \RuntimeException('PROVIDER.EVIDENCE_LIMIT'); }
            $decision = (new Engine())->decide($policy, $signals, $findings);
            if ($ok && $decision->action->publishable() && \ContentFirewall\Policy\EvidenceCoverage::missing($policy, $findings, $signals)) { $decision = new Decision(Action::Review, ['provider.coverage_incomplete'], [], $policy->id, $policy->version, $decision->risk, $policy->shadow); }
            if (!$ok && $decision->action !== Action::Block) { $decision = new Decision(match ($policy->options['failure_mode'] ?? 'QUARANTINE') { 'FAIL_OPEN' => Action::Allow, 'FAIL_CLOSED' => Action::Block, default => Action::Quarantine }, ['provider.unavailable'], [], $policy->id, $policy->version, 0); }
            if ($textMissing && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.text_unavailable'], [], $policy->id, $policy->version, 0, $policy->shadow); }
            if (($policy->options['consensus'] ?? false) && (count($identities) < 2 || \ContentFirewall\Policy\EvidenceCoverage::consensusIncomplete($policy, $results)) && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.consensus_incomplete'], [], $policy->id, $policy->version, 0, $policy->shadow); }
            if (($signals['media_coverage_incomplete'] ?? false) && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, array_values(array_unique(array_merge($decision->reasons, ['provider.media_coverage_incomplete']))), $decision->rules, $policy->id, $policy->version, $decision->risk); }
            foreach ($providerScores as $scales) { $scores = $scales['probability'] ?? []; if (count($scores) > 1 && max($scores) - min($scores) > 0.35 && $decision->action !== Action::Block) { $decision = new Decision(Action::Review, ['provider.disagreement'], [], $policy->id, $policy->version, max($scores), $policy->shadow); } }
            if ($decision->action !== Action::Block && array_filter($findings, static fn(Finding $f): bool => $f->category === 'security.requires_document_cdr')) { $decision = new Decision(Action::Review, ['security.requires_document_cdr'], [], $policy->id, $policy->version, 1); }
            unset($signals['ocr_text']);
            return ['decision' => $decision, 'signals' => $signals, 'findings' => $findings, 'results' => $results];
        } finally { if ($derivative && is_file($derivative)) { unlink($derivative); } }
    }
    private function text(FileDescriptor $file): string
    {
        if ($file->bytes > 65536) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
        $text = file_get_contents($file->path);
        if ($text === false || !hash_equals($file->sha256, hash('sha256', $text))) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        return $text;
    }
    public function rescan(int $id, ?int $expectedRevision = null, ?callable $onQueued = null): void
    {
        if ($this->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $row = $this->scans->get($id); $revision = $expectedRevision ?? (int)$row['revision'];
        if ((int)$row['revision'] !== $revision || $row['private_key'] === '') { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        if ($row['expires_at'] <= gmdate('Y-m-d H:i:s')) { throw new \RuntimeException('STORAGE.EXPIRED'); }
        $policy = $this->policies->active();
        $this->scans->queueRescan($id, $revision, $policy, function () use ($id, $revision, $onQueued): void {
            $this->jobs->enqueue('rescan', ['scan_id' => $id, 'revision' => $revision + 1], 'rescan:' . $id . ':' . ($revision + 1));
            if ($onQueued) { $onQueued(); }
        });
    }
    private function move(int $id, State $to): void
    {
        $row = $this->scans->get($id); if (!$this->scans->transition($id, (int)$row['revision'], $to)) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $this->audit->record('scan.transition', $id, 0, ['state' => $to->value, 'revision' => (int)$row['revision'] + 1]);
    }
    public function publicationDecision(Decision $decision, Policy $policy, array $signals, array $findings): Decision
    {
        if ($decision->action === Action::Sanitize && !$decision->shadow && (str_starts_with($signals['mime'] ?? '', 'video/') || str_starts_with($signals['mime'] ?? '', 'audio/'))) { $decision = new Decision(Action::Review, ['privacy.temporal_redaction_unavailable'], $decision->rules, $decision->policyId, $decision->policyVersion, $decision->risk); }
        if ($decision->action === Action::Sanitize && !$decision->shadow && ($signals['mime'] ?? '') === 'text/plain' && ($signals['bytes'] ?? 0) > 16384) { $decision = new Decision(Action::Review, ['privacy.redaction_unavailable'], $decision->rules, $decision->policyId, $decision->policyVersion, $decision->risk); }
        if ($decision->action === Action::Sanitize && !$decision->shadow && ($signals['mime'] ?? '') === 'text/plain') {
            $builder = new \ContentFirewall\Media\DerivativeBuilder();
            $categories = $builder->categories($policy, $decision->rules); $supported = array_merge((new TextInspector())->categories(), array_keys($policy->options['patterns'] ?? []));
            $unsupported = (bool)array_filter($findings, static fn(Finding $f): bool => $builder->requested($f, $categories) && !in_array($f->category, $supported, true));
            foreach ($policy->rules as $rule) { if (in_array($rule['id'], $decision->rules, true) && in_array('ocr_text', \ContentFirewall\Policy\EvidenceCoverage::fields($rule['condition']), true)) { $unsupported = true; } }
            if ($unsupported) { $decision = new Decision(Action::Review, ['privacy.redaction_unavailable'], $decision->rules, $decision->policyId, $decision->policyVersion, $decision->risk); }
        }
        if ($decision->action === Action::Sanitize && !$decision->shadow && ($signals['mime'] ?? '') !== 'text/plain') {
            $builder = new \ContentFirewall\Media\DerivativeBuilder();
            $categories = $builder->categories($policy, $decision->rules);
            if (array_filter($findings, static fn(Finding $f): bool => $builder->requested($f, $categories) && ($f->region === null || !($signals['width'] ?? 0)))) { $decision = new Decision(Action::Review, ['privacy.redaction_unavailable'], $decision->rules, $decision->policyId, $decision->policyVersion, $decision->risk); }
        }
        return $decision;
    }
    private function finish(int $id, Decision $decision, array $signals, array $findings, ?int $expectedRevision = null, bool $fromQueue = false): Decision
    {
        if ($decision->action === Action::Sanitize) { $decision = $this->publicationDecision($decision, $this->policies->get($decision->policyId, $decision->policyVersion), $signals, $findings); }
        $row = $this->scans->get($id); $enforced = $decision->shadow ? Action::Allow : $decision->action;
        $state = match ($enforced) { Action::Allow => State::Allowed, Action::Sanitize => State::Sanitizing, Action::Review => State::Review, Action::Quarantine => State::Quarantined, Action::Block => State::Blocked };
        if (!$this->scans->complete($id, $expectedRevision ?? (int)$row['revision'], $state, $decision, $signals, $findings, $fromQueue, function () use ($id, $decision): void {
            // Lock/renew the owned job in the same transaction as the decision commit.
            $this->router->pulse();
            $this->audit->record('scan.decision', $id, 0, ['action' => $decision->action->value, 'policy' => $decision->policyId, 'version' => $decision->policyVersion, 'shadow' => $decision->shadow]);
            if ($this->onDecision) { ($this->onDecision)($id, $decision); }
        })) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        // Extension notification failures cannot undo a committed moderation decision.
        try { do_action('cf_scan_completed', $id, $decision); }
        catch (\Throwable $e) { try { $this->audit->record('scan.listener_failed', $id, 0, ['code' => self::errorCode($e)]); } catch (\Throwable) {} }
        return $decision;
    }
    public static function errorCode(\Throwable $e): string { return preg_match('/^[A-Z]+\.[A-Z0-9_]+$/D', $e->getMessage()) ? $e->getMessage() : 'CONFIGURATION.INTERNAL'; }
}
