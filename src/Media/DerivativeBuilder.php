<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\{FileDescriptor, Finding, Policy, Taxonomy};
use ContentFirewall\Privacy\TextInspector;

/** Shared publication reconstruction for synchronous uploads and queued approvals. */
final class DerivativeBuilder
{
    public function __construct(private ?DocumentMedia $documents = null, private ?TemporalMedia $temporal = null) {}
    /** @param list<Finding> $findings */
    public function build(FileDescriptor $file, string $destination, bool $sanitize = false, array $findings = [], array $patterns = [], array $categories = []): void
    {
        if ($file->width > 0) {
            $regions = [];
            if ($sanitize) {
                foreach ($findings as $finding) {
                    if (!$this->requested($finding, $categories)) { continue; }
                    if ($finding->region === null) { throw new \RuntimeException('PRIVACY.REDACTION_UNAVAILABLE'); }
                    $regions[] = $finding->region;
                }
            }
            (new ImageProcessor())->reencode($file, $destination, 0, $regions);
        } elseif ($file->mime === 'image/svg+xml') {
            (new \ContentFirewall\Security\SvgReconstructor())->reconstruct($file, $destination);
        } elseif ($file->mime === 'text/plain') {
            if ($sanitize) {
                if ($file->bytes > 16384) { throw new \RuntimeException('PRIVACY.REDACTION_UNAVAILABLE'); }
                $text = file_get_contents($file->path);
                if ($text === false || !hash_equals($file->sha256, hash('sha256', $text))) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
                $redacted = (new TextInspector())->sanitize($text, $patterns);
                if (file_put_contents($destination, $redacted) === false) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
            } elseif (!copy($file->path, $destination)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
        } elseif ($file->mime === 'application/pdf' && $this->documents) {
            if ($sanitize) { throw new \RuntimeException('PRIVACY.REDACTION_UNAVAILABLE'); } $this->documents->reconstruct($file, $destination);
        } elseif ($this->temporal && (str_starts_with($file->mime, 'audio/') || str_starts_with($file->mime, 'video/'))) {
            if ($sanitize) { throw new \RuntimeException('PRIVACY.REDACTION_UNAVAILABLE'); } $this->temporal->reconstruct($file, $destination);
        } else { throw new \RuntimeException('SECURITY.PUBLICATION_DENIED'); }
        if (!chmod($destination, 0600)) { throw new \RuntimeException('STORAGE.PERMISSIONS'); }
    }

    public function sensitive(Finding $finding): bool
    {
        return $finding->confidence > 0 && (str_starts_with($finding->category, 'pii.') || str_starts_with($finding->category, 'qr.') || str_starts_with($finding->category, 'face.') || str_starts_with($finding->category, 'privacy.'));
    }
    public function requested(Finding $finding, array $categories): bool
    {
        return $this->sensitive($finding) || ($finding->confidence > 0 && (in_array($finding->category, $categories, true) || in_array(Taxonomy::PARENTS[$finding->category] ?? '', $categories, true)));
    }
    public function categories(Policy $policy, array $ruleIds): array
    {
        $categories = [];
        foreach ($policy->rules as $rule) { if (in_array($rule['id'], $ruleIds, true)) { foreach (\ContentFirewall\Policy\EvidenceCoverage::fields($rule['condition']) as $field) { if (\ContentFirewall\Policy\EvidenceCoverage::requiresEvidence($field) && $field !== 'ocr_text') { $categories[] = $field; } } } }
        return array_values(array_unique($categories));
    }
}
