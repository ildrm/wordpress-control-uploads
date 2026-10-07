<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, Decision, Finding, Policy, ProviderResult, UploadContext};
use ContentFirewall\Policy\Engine;
/** Real file analysis shares the scanner pipeline without any publication/scan job. */
final class FileSimulator
{
    public function __construct(private Services $s) {}
    public function run(string $path, string $name, string $mime, Policy $policy): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $original = $this->s->inspector->inspect($path, $name, $mime); $temp = $this->s->storage->temporary($this->s->siteId); $derivative = null; $start = microtime(true);
        try {
            if (!copy($original->path, $temp)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
            $file = $this->s->inspector->inspect($temp, $name, $mime); if (!hash_equals($original->sha256, $file->sha256)) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
            $user = wp_get_current_user(); $context = new UploadContext($this->s->siteId, $user->ID, 'simulation', array_values($user->roles), networkId: is_multisite() ? get_current_network_id() : 0); $signals = $context->signals() + $file->signals();
            try { $findings = $this->s->security->inspect($file); }
            catch (\Throwable $e) { return $this->report(new Decision(Action::Quarantine, [ScanService::errorCode($e)], [], $policy->id, $policy->version, 1), $signals, [], [], $start); }
            $blocked = $this->s->scans->fingerprint($file->sha256) === 'BLOCK';
            if ($blocked) { $findings[] = new Finding('fingerprint.blocked', 1, 'local', '1', false, 'deterministic'); }
            if ($blocked || array_filter($findings, static fn($f): bool => $f->hardSecurity)) {
                $decision = (new Engine())->decide($policy, $signals, $findings);
                if ($decision->action !== Action::Block) { $decision = new Decision(Action::Block, ['fingerprint.blocked'], [], $policy->id, $policy->version, 1, $policy->shadow); }
                return $this->report($decision, $signals, $findings, [], $start);
            }
            $analysis = $this->s->scanner->evaluateFile($file, $policy, $signals, $findings); $decision = $this->s->scanner->publicationDecision($analysis['decision'], $policy, $analysis['signals'], $analysis['findings']);
            if ($decision->action === Action::Sanitize && !$decision->shadow) {
                $derivative = $this->s->storage->temporary($this->s->siteId); $builder = new \ContentFirewall\Media\DerivativeBuilder($this->s->documents, $this->s->temporal);
                try { $builder->build($file, $derivative, true, $analysis['findings'], $policy->options['patterns'] ?? [], $builder->categories($policy, $decision->rules)); $this->s->inspector->inspect($derivative, $name, $mime); }
                catch (\Throwable) { $decision = new Decision(Action::Review, ['privacy.redaction_unavailable'], $decision->rules, $policy->id, $policy->version, $decision->risk); }
            }
            return $this->report($decision, $analysis['signals'], $analysis['findings'], $analysis['results'], $start);
        } finally { foreach ([$temp, $derivative] as $file) { if ($file !== null && is_file($file)) { unlink($file); } } }
    }
    private function report(Decision $decision, array $signals, array $findings, array $results, float $start): array
    {
        unset($signals['ocr_text']);
        $providers = array_map(static fn(ProviderResult $r): array => ['provider' => $r->provider, 'model' => $r->model, 'error' => $r->error, 'duration_ms' => $r->durationMs, 'estimated_cost' => $r->estimatedCost, 'language' => $r->language], $results);
        $this->s->audit->record('simulation.completed', 0, get_current_user_id(), ['action' => $decision->action->value, 'policy' => $decision->policyId, 'version' => $decision->policyVersion]);
        return ['decision' => $decision, 'findings' => $findings, 'providers' => $providers, 'signals' => $signals, 'duration_ms' => (microtime(true) - $start) * 1000, 'estimated_cost' => array_sum(array_column($providers, 'estimated_cost')), 'published' => false];
    }
}
