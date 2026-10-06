<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
use ContentFirewall\Domain\Finding;
final class ArchiveInspector
{
    /** No extraction to a filesystem, and nested archives are rejected rather than expanded. @return list<Finding> */
    public function inspect(string $path, bool $office = false): array
    {
        if (!class_exists(\ZipArchive::class)) { throw new \RuntimeException('CONFIGURATION.ZIP_REQUIRED'); }
        $zip = new \ZipArchive();
        if ($zip->open($path, \ZipArchive::RDONLY) !== true) { throw new \RuntimeException('SECURITY.ARCHIVE_PARSE'); }
        try {
            $total = 0; $findings = []; $officeMarker = false;
            if ($zip->numFiles > 1000) { throw new \RuntimeException('SECURITY.ARCHIVE_COUNT'); }
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                if (!$stat || preg_match('~(^/|(^|/)\.\.(/|$)|[\\\\\x00-\x1f]|^[a-z]:)~i', $stat['name'])) { throw new \RuntimeException('SECURITY.ARCHIVE_PATH'); }
                $total += $stat['size'];
                if ($total > 104857600 || $stat['size'] > 16777216 || $stat['size'] / max(1, $stat['comp_size']) > 100 || ($stat['encryption_method'] ?? 0) !== 0) { throw new \RuntimeException('SECURITY.ARCHIVE_RESOURCE'); }
                $opsys = $attrs = 0; $zip->getExternalAttributesIndex($i, $opsys, $attrs);
                if (($attrs >> 16 & 0170000) === 0120000) { throw new \RuntimeException('SECURITY.ARCHIVE_SYMLINK'); }
                $name = strtolower($stat['name']);
                if ($name === '[content_types].xml') { $officeMarker = true; }
                if (preg_match('/\.(zip|rar|7z|gz|tar|bz2|xz)$/', $name)) { throw new \RuntimeException('SECURITY.ARCHIVE_NESTING'); }
                if (preg_match('/\.(exe|dll|com|bat|cmd|php|phtml|phar|js|vbs|ps1|sh)$/', $name) || str_contains($name, 'vbaproject') || str_contains($name, 'embeddings/')) { $findings[] = new Finding('security.embedded_active', 1, 'local', '1', true, 'deterministic'); }
                if (str_ends_with($name, '.rels') || ($office && str_ends_with($name, '.xml'))) {
                    $text = $zip->getFromIndex($i, 1048577);
                    if ($text === false || strlen($text) > 1048576 || preg_match('/<!ENTITY|<!DOCTYPE|TargetMode\s*=\s*["\x27]External/i', $text)) { $findings[] = new Finding('security.office_external', 1, 'local', '1', true, 'deterministic'); }
                }
                if (!$office && !str_ends_with($name, '/')) {
                    $bytes = $zip->getFromIndex($i, 4096);
                    if ($bytes === false || str_starts_with($bytes, 'MZ') || str_starts_with($bytes, "\x7fELF") || str_contains($bytes, '<?php')) { $findings[] = new Finding('security.embedded_active', 1, 'local', '1', true, 'deterministic'); }
                }
            }
            if ($office && !$officeMarker) { throw new \RuntimeException('SECURITY.OFFICE_STRUCTURE'); }
            return $findings;
        } finally { $zip->close(); }
    }
}
