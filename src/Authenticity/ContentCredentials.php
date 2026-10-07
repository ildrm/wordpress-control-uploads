<?php
declare(strict_types=1);
namespace ContentFirewall\Authenticity;
use ContentFirewall\Domain\{FileDescriptor, Finding};
use ContentFirewall\Infrastructure\ProcessRunner;
use ContentFirewall\Security\PrivateStorage;
/** Pinned offline verification; absence and signer trust are separate from authenticity. */
final class ContentCredentials
{
    public function __construct(private string $binary, private PrivateStorage $storage, private int $siteId, private string $anchors = '', private ProcessRunner $runner = new ProcessRunner()) {}
    public function inspect(FileDescriptor $file): array
    {
        if (!in_array($file->mime, ['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'video/mp4', 'audio/mp4', 'audio/mpeg', 'audio/wav', 'audio/x-wav'], true)) { $result = $this->absent(); $result['findings'] = []; $result['report']['state'] = 'unsupported'; return $result; }
        if (!hash_equals($file->sha256, (string)hash_file('sha256', $file->path))) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        $workspace = $this->storage->workspace($this->siteId);
        try {
            $version = $this->runner->run([$this->binary, '--version'], $workspace, 5000, 256);
            if ($version['exit_code'] !== 0 || trim($version['stdout']) !== 'c2patool 0.28.1') { throw new \RuntimeException('CONFIGURATION.C2PA_VERSION'); }
            $settings = ['verify' => ['verify_after_reading' => true, 'remote_manifest_fetch' => false, 'ocsp_fetch' => false, 'verify_trust' => $this->anchors !== ''], 'core' => ['allowed_network_hosts' => []]];
            if ($this->anchors !== '') {
                if (!str_starts_with($this->anchors, '/') || !is_file($this->anchors) || filesize($this->anchors) > 1048576) { throw new \RuntimeException('CONFIGURATION.C2PA_TRUST'); }
                $settings['trust'] = ['trust_anchors' => (string)file_get_contents($this->anchors)];
            }
            $path = $workspace . '/settings.json'; file_put_contents($path, json_encode($settings, JSON_THROW_ON_ERROR)); chmod($path, 0600);
            // Give the tool a known extension, in an isolated directory without adjacent sidecars.
            $asset = $workspace . '/asset.' . strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            if (!copy($file->path, $asset)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } chmod($asset, 0600);
            $reply = $this->runner->run([$this->binary, $asset, '--settings', $path], $workspace, 30000, 1048576);
            if ($reply['exit_code'] !== 0) {
                if ($reply['exit_code'] === 1 && trim($reply['stderr']) === 'Error: No claim found') { return $this->absent(); }
                throw new \RuntimeException('PROVIDER.C2PA_UNAVAILABLE');
            }
            try { $value = json_decode($reply['stdout'], true, 32, JSON_THROW_ON_ERROR); }
            catch (\JsonException) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
            if (!is_array($value)) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
            return $this->parse($value, $this->anchors !== '');
        } finally { $this->storage->removeWorkspace($workspace, $this->siteId); }
    }
    public function absent(): array
    {
        return ['findings' => [new Finding('provenance.present', 0, 'c2pa', 'c2patool-0.28.1', scale: 'deterministic')], 'report' => ['state' => 'absent', 'signature_valid' => null, 'trusted' => null, 'issuer' => '', 'assertions' => [], 'actions' => [], 'ai_declared' => null, 'remote_fetch' => false]];
    }
    public function parse(array $data, bool $trustChecked = false): array
    {
        $active = $data['active_manifest'] ?? null;
        if (!is_string($active) || !is_array($data['manifests'][$active] ?? null) || !in_array($data['validation_state'] ?? null, ['Valid', 'Trusted', 'Invalid'], true)) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
        $manifest = $data['manifests'][$active]; $validation = $data['validation_results']['activeManifest'] ?? null;
        if (!is_array($validation) || !is_array($validation['success'] ?? null) || !is_array($validation['failure'] ?? null) || count($validation['success']) + count($validation['failure']) > 256 || !is_array($manifest['assertions'] ?? [])) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
        $success = array_column($validation['success'], 'code'); $failures = array_column($validation['failure'], 'code');
        foreach (array_merge($validation['success'], $validation['failure']) as $status) { if (!is_array($status) || !is_string($status['code'] ?? null) || !preg_match('/^[a-zA-Z0-9_.-]{1,96}$/D', $status['code'])) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); } }
        $bound = (bool)array_intersect($success, ['assertion.dataHash.match', 'assertion.bmffHash.match', 'assertion.boxesHash.match']);
        $valid = $bound && in_array('claimSignature.validated', $success, true) && !array_filter($failures, static fn($code): bool => is_string($code) && !str_starts_with($code, 'signingCredential.') && !str_starts_with($code, 'timeStamp.'));
        $trusted = $trustChecked ? $data['validation_state'] === 'Trusted' : null;
        $issuer = $manifest['signature_info']['issuer'] ?? ''; if (!is_string($issuer) || strlen($issuer) > 200 || !mb_check_encoding($issuer, 'UTF-8')) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
        $labels = $actions = []; $ai = false;
        foreach ($manifest['assertions'] ?? [] as $assertion) {
            $label = $assertion['label'] ?? null; if (!is_string($label) || !preg_match('/^[a-zA-Z0-9_.-]{1,96}$/D', $label) || count($labels) >= 100) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); } $labels[] = $label;
            if (str_starts_with($label, 'c2pa.actions')) {
                if (!is_array($assertion['data']['actions'] ?? null) || count($assertion['data']['actions']) > 100) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
                foreach ($assertion['data']['actions'] as $action) {
                    $name = $action['action'] ?? ''; if (!is_string($name) || !preg_match('/^[a-zA-Z0-9_.-]{1,96}$/D', $name)) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); } $actions[] = $name;
                    $source = $action['digitalSourceType'] ?? ''; if (!is_string($source)) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
                    if (in_array(basename($source), ['trainedAlgorithmicMedia', 'compositeWithTrainedAlgorithmicMedia'], true)) { $ai = true; }
                }
            }
        }
        if (count($actions) > 100) { throw new \RuntimeException('PROVIDER.C2PA_SCHEMA'); }
        $findings = [new Finding('provenance.present', 1, 'c2pa', 'c2patool-0.28.1', scale: 'deterministic'), new Finding('provenance.signature_valid', $valid ? 1 : 0, 'c2pa', 'c2patool-0.28.1', scale: 'deterministic')];
        if ($valid) { $findings[] = new Finding('authenticity.ai_declared', $ai ? 1 : 0, 'c2pa', 'c2patool-0.28.1', scale: 'deterministic'); }
        if ($trusted !== null) { $findings[] = new Finding('provenance.trusted', $trusted ? 1 : 0, 'c2pa', 'c2patool-0.28.1', scale: 'deterministic'); }
        return ['findings' => $findings, 'report' => ['state' => strtolower($data['validation_state']), 'signature_valid' => $valid, 'trusted' => $trusted, 'issuer' => $issuer, 'assertions' => array_values(array_unique($labels)), 'actions' => $actions, 'ai_declared' => $valid ? $ai : null, 'remote_fetch' => false]];
    }
}
