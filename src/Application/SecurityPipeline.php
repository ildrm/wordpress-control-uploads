<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Domain\{FileDescriptor, Finding};
use ContentFirewall\Security\{ArchiveInspector, MalwareScanner, SvgSanitizer};
final class SecurityPipeline
{
    public function __construct(private ?MalwareScanner $malware = null, private bool $requireMalware = false) {}
    /** @return list<Finding> */
    public function inspect(FileDescriptor $file): array
    {
        $findings = [];
        if ($this->requireMalware && !$this->malware) { throw new \RuntimeException('CONFIGURATION.MALWARE_REQUIRED'); }
        if ($this->malware) {
            $status = $this->malware->scan($file->path);
            if ($status === 'SCANNER_ERROR') { throw new \RuntimeException('SECURITY.SCANNER_ERROR'); }
            if ($status !== 'CLEAN') { $findings[] = new Finding('security.malware', 1, 'clamd', 'signatures-current', true, 'deterministic'); }
        }
        $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
        if (in_array($ext, ['zip', 'docx', 'xlsx', 'pptx'], true)) { $findings = array_merge($findings, (new ArchiveInspector())->inspect($file->path, $ext !== 'zip')); }
        if ($ext === 'svg') {
            (new SvgSanitizer())->sanitize((string)file_get_contents($file->path));
            $findings[] = new Finding('security.requires_svg_cdr', 1, 'local', '1', false, 'deterministic');
        }
        if ($ext === 'pdf') {
            $handle = fopen($file->path, 'rb'); $head = $handle ? fread($handle, 8) : ''; if ($handle) { fclose($handle); }
            if (!str_starts_with($head ?: '', '%PDF-')) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
            // Token searches cannot certify a PDF: compressed/object streams conceal actions.
            $findings[] = new Finding('security.requires_document_cdr', 1, 'local', '1', false, 'deterministic');
        }
        if (in_array($ext, ['docx', 'xlsx', 'pptx', 'zip'], true)) { $findings[] = new Finding('security.requires_document_cdr', 1, 'local', '1', false, 'deterministic'); }
        return $findings;
    }
}
