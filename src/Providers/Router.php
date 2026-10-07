<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Policy, ProviderResult};
use ContentFirewall\Persistence\{AuditRepository, Limiter, SignalCache, Tables};
final class Router
{
    private ?\Closure $heartbeat = null;
    /** @param null|callable():void $heartbeat */
    public function setHeartbeat(?callable $heartbeat): void { $this->heartbeat = $heartbeat === null ? null : \Closure::fromCallable($heartbeat); }
    public function pulse(): void { if ($this->heartbeat) { ($this->heartbeat)(); } }
    /** @param list<Provider> $providers */
    public function __construct(private array $providers, private SignalCache $cache, private Limiter $limiter, private AuditRepository $audit, private \wpdb $db, private Tables $tables, private int $monthlyCap = 10000) {}
    /** @return list<ProviderResult> */
    public function scan(FileDescriptor $file, Policy $policy, int $scanId, array $priorFindings = [], array $priorSignals = []): array
    {
        $results = []; $success = false;
        foreach ($this->providers as $provider) {
            $this->pulse();
            $cap = $provider->capabilities();
            if (!in_array($file->mime, $cap['mimes'], true)) { continue; }
            $region = $policy->options['region'] ?? null;
            if ($region !== null && !in_array($region, $cap['regions'], true)) { continue; }
            $key = $this->cache->key($file->sha256, $provider->id(), $cap['model'], json_encode($cap, JSON_THROW_ON_ERROR));
            // An API version or mutable model alias does not establish model compatibility.
            $cacheable = (bool)($cap['cacheable'] ?? false);
            $cached = $cacheable ? $this->cache->get($key) : null;
            if ($cached) {
                $results[] = $cached; $success = true;
                if ($this->sufficient($results, $policy, $priorFindings, $priorSignals)) { break; }
                continue;
            }
            $breaker = get_option('cf_breaker_' . $provider->id(), ['failures' => 0, 'until' => 0]);
            if ($breaker['until'] > time()) { $results[] = new ProviderResult($provider->id(), $cap['model'], [], 'PROVIDER.CIRCUIT_OPEN', true); continue; }
            if (!$this->limiter->consumeMonth('provider:' . $provider->id(), $this->monthlyCap)) { $results[] = new ProviderResult($provider->id(), $cap['model'], [], 'PROVIDER.BUDGET'); continue; }
            try { $result = $provider->scan($file); }
            catch (\Throwable) { $result = new ProviderResult($provider->id(), $cap['model'], [], 'PROVIDER.SCHEMA'); }
            $results[] = $result;
            $this->audit->record('provider.scan', $scanId, 0, ['provider' => $provider->id(), 'model' => $result->model, 'duration_ms' => $result->durationMs, 'code' => $result->error ?? 'OK']);
            $this->db->query($this->db->prepare('INSERT INTO %i (provider,day,requests,failures,latency_ms,cost) VALUES (%s,%s,1,%d,%f,%f) ON DUPLICATE KEY UPDATE requests=requests+1,failures=failures+VALUES(failures),latency_ms=latency_ms+VALUES(latency_ms),cost=cost+VALUES(cost)', $this->tables->name('usage'), $provider->id(), gmdate('Y-m-d'), $result->error ? 1 : 0, $result->durationMs, $result->estimatedCost));
            $failures = $result->error ? (int)$breaker['failures'] + 1 : 0;
            update_option('cf_breaker_' . $provider->id(), ['failures' => $failures, 'until' => $failures >= 3 ? time() + 60 : 0], false);
            if ($result->error) { continue; }
            $success = true; if ($cacheable) { $this->cache->put($key, $result); }
            if ($this->sufficient($results, $policy, $priorFindings, $priorSignals)) { break; }
        }
        if (!$success) { $results[] = new ProviderResult('router', '1', [], 'PROVIDER.UNAVAILABLE'); }
        return $results;
    }
    public function status(): array
    {
        return array_map(static fn(Provider $p): array => ['id' => $p->id(), 'capabilities' => $p->capabilities(), 'health' => get_option('cf_breaker_' . $p->id(), ['failures' => 0, 'until' => 0])], $this->providers);
    }
    public function text(string $text, int $scanId, ?Policy $policy = null): ProviderResult
    {
        foreach ($this->providers as $provider) {
            $this->pulse();
            if (!$provider instanceof TextProvider) { continue; }
            $cap = $provider->capabilities(); $region = $policy?->options['region'] ?? null;
            if ($region !== null && !in_array($region, $cap['regions'], true)) { continue; }
            $breaker = get_option('cf_breaker_' . $provider->id(), ['failures' => 0, 'until' => 0]);
            if ($breaker['until'] > time()) { continue; }
            if (!$this->limiter->consumeMonth('provider:' . $provider->id(), $this->monthlyCap)) { continue; }
            try { $result = $provider->scanText($text); }
            catch (\Throwable) { $result = new ProviderResult($provider->id(), $cap['model'], [], 'PROVIDER.TEXT_FAILURE'); }
            $this->audit->record('provider.text_scan', $scanId, 0, ['provider' => $provider->id(), 'model' => $result->model, 'code' => $result->error ?? 'OK']);
            $this->db->query($this->db->prepare('INSERT INTO %i (provider,day,requests,failures) VALUES (%s,%s,1,%d) ON DUPLICATE KEY UPDATE requests=requests+1,failures=failures+VALUES(failures)', $this->tables->name('usage'), $provider->id(), gmdate('Y-m-d'), $result->error ? 1 : 0));
            $failures = $result->error ? (int)$breaker['failures'] + 1 : 0;
            update_option('cf_breaker_' . $provider->id(), ['failures' => $failures, 'until' => $failures >= 3 ? time() + 60 : 0], false);
            if (!$result->error) { return $result; }
        }
        return new ProviderResult('router', '1', [], 'PROVIDER.TEXT_UNAVAILABLE');
    }
    /** @param list<ProviderResult> $results */
    private function sufficient(array $results, Policy $policy, array $priorFindings, array $priorSignals): bool
    {
        $ok = array_values(array_filter($results, static fn(ProviderResult $r): bool => $r->error === null));
        $findings = $priorFindings; $text = '';
        foreach ($ok as $result) { $findings = array_merge($findings, $result->findings); if ($result->text !== '') { $text = $result->text; $findings = array_merge($findings, (new \ContentFirewall\Privacy\TextInspector())->inspect($result->text, $policy->options['patterns'] ?? [])); } }
        if (\ContentFirewall\Policy\EvidenceCoverage::missing($policy, $findings, ($text !== '' ? ['ocr_text' => $text] : []) + $priorSignals) || (($policy->options['requires_text'] ?? false) && $text === '')) { return false; }
        if (\ContentFirewall\Policy\EvidenceCoverage::consensusIncomplete($policy, $ok)) { return false; }
        $minimum = ($policy->options['consensus'] ?? false) || $this->uncertain($findings, $text, $policy) ? 2 : 1;
        return count(array_unique(array_map(static fn(ProviderResult $r): string => $r->provider, $ok))) >= $minimum;
    }
    private function uncertain(array $findings, string $text, Policy $policy): bool
    {
        if (\ContentFirewall\Policy\EvidenceCoverage::missing($policy, $findings, $text !== '' ? ['ocr_text' => $text] : [])) { return true; }
        if (($policy->options['requires_text'] ?? false) && $text === '') { return true; }
        $scores = []; foreach ($findings as $finding) { if ($finding->category === 'provider.unknown') { return true; } $scores[$finding->category] = max($scores[$finding->category] ?? 0, $finding->confidence); }
        $scores = (new \ContentFirewall\Domain\Taxonomy())->expand($scores);
        foreach ($policy->bands as $category => $band) { if (($scores[$category] ?? 0) >= $band['review']) { return true; } }
        return false;
    }
}
