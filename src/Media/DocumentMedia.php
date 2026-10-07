<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\{FileDescriptor, Policy, ProviderResult};
use ContentFirewall\Infrastructure\ProcessRunner;
use ContentFirewall\Security\{ContentReconstructor, FileInspector, PrivateStorage};
final class DocumentMedia implements ContentReconstructor
{
    public function __construct(private string $pdfinfo, private string $pdftoppm, private string $pdftotext, private PrivateStorage $storage, private int $siteId, private int $maximumPages = 20, private ProcessRunner $runner = new ProcessRunner()) {}
    public function configured(): bool { return $this->pdfinfo !== '' && $this->pdftoppm !== '' && $this->pdftotext !== ''; }
    public function supportedMimes(): array { return ['application/pdf']; }
    /** @param callable(FileDescriptor):list<ProviderResult> $scan @return array{results:array,signals:array} */
    public function inspect(FileDescriptor $file, Policy $policy, callable $scan, array $priorFindings = [], array $priorSignals = []): array
    {
        $workspace = $this->storage->workspace($this->siteId);
        try {
            $rendered = $this->render($file, $workspace); $pages = $rendered['pages']; $results = []; $incomplete = false;
            foreach ($pages as $page) {
                if ($policy->options['requires_content'] ?? false) {
                    $part = $scan($page); $results = array_merge($results, $part); $findings = $priorFindings; $ok = false; $pageSignals = $priorSignals;
                    foreach ($part as $result) { if (!$result->error) { $ok = true; $findings = array_merge($findings, $result->findings); if ($result->text !== '') { $pageSignals['ocr_text'] = $result->text; $findings = array_merge($findings, (new \ContentFirewall\Privacy\TextInspector())->inspect($result->text, $policy->options['patterns'] ?? [])); } } }
                    $incomplete = $incomplete || !$ok || (bool)\ContentFirewall\Policy\EvidenceCoverage::missing($policy, $findings, $pageSignals) || \ContentFirewall\Policy\EvidenceCoverage::consensusIncomplete($policy, $part);
                }
            }
            $reply = $this->runner->run([$this->pdftotext, '-enc', 'UTF-8', $file->path, '-'], $workspace, 15000, 65536);
            if ($reply['exit_code'] !== 0) { throw new \RuntimeException('SECURITY.PDF_TEXT'); }
            $results[] = new ProviderResult('local-document', 'image-pdf-v1', [], text: $reply['stdout']);
            return ['results' => ResultAccumulator::merge($results), 'signals' => ['pages' => count($pages), 'document_cdr' => true, 'media_coverage_incomplete' => $incomplete]];
        } finally { $this->storage->removeWorkspace($workspace, $this->siteId); }
    }
    public function reconstruct(FileDescriptor $source, string $destination): void
    {
        $workspace = $this->storage->workspace($this->siteId);
        try { $rendered = $this->render($source, $workspace); (new ImagePdf())->write($rendered['pages'], $destination, $rendered['sizes']); }
        finally { $this->storage->removeWorkspace($workspace, $this->siteId); }
    }
    /** @return array{pages:list<FileDescriptor>,sizes:list<array{float,float}>} */
    private function render(FileDescriptor $file, string $workspace): array
    {
        if ($file->mime !== 'application/pdf' || !hash_equals($file->sha256, (string)hash_file('sha256', $file->path))) { throw new \RuntimeException('SECURITY.CDR_INPUT'); }
        $reply = $this->runner->run([$this->pdfinfo, $file->path], $workspace, 15000, 16384);
        if ($reply['exit_code'] !== 0 || !preg_match('/^Pages:\s+(\d+)\s*$/m', $reply['stdout'], $match) || !preg_match('/^Encrypted:\s+no\s*$/m', $reply['stdout'])) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
        $count = (int)$match[1]; if ($count < 1 || $count > $this->maximumPages) { throw new \RuntimeException('SECURITY.PDF_PAGES'); }
        $info = $this->runner->run([$this->pdfinfo, '-f', '1', '-l', (string)$count, $file->path], $workspace, 15000, 32768); $sizes = [];
        if ($info['exit_code'] !== 0) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
        for ($page = 1; $page <= $count; $page++) {
            if (!preg_match('/^Page\s+' . $page . '\s+size:\s+([0-9.]+) x ([0-9.]+) pts/m', $info['stdout'], $size) || !preg_match('/^Page\s+' . $page . '\s+rot:\s+(0|90|180|270)\s*$/m', $info['stdout'], $rotation)) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
            $w = (float)$size[1]; $h = (float)$size[2];
            if (!is_finite($w) || !is_finite($h) || $w < 1 || $h < 1 || $w > 14400 || $h > 14400) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
            $sizes[] = in_array((int)$rotation[1], [90, 270], true) ? [$h, $w] : [$w, $h];
        }
        $reply = $this->runner->run([$this->pdftoppm, '-f', '1', '-l', (string)$count, '-scale-to', '2048', '-png', $file->path, $workspace . '/page'], $workspace, 90000, 16384);
        if ($reply['exit_code'] !== 0) { throw new \RuntimeException('SECURITY.PDF_RENDER'); }
        $validator = new FileInspector(16777216, 4194304, ['png', 'jpg']); $paths = glob($workspace . '/page-*.png') ?: []; natsort($paths);
        if (count($paths) !== $count) { throw new \RuntimeException('SECURITY.PDF_PAGES'); }
        $pages = [];
        foreach ($paths as $path) {
            $raw = $validator->inspect($path, basename($path), 'image/png'); $jpg = $workspace . '/' . pathinfo($path, PATHINFO_FILENAME) . '.jpg';
            $im = imagecreatefrompng($raw->path); if (!$im) { throw new \RuntimeException('SECURITY.PDF_RENDER'); }
            try { if (!imagejpeg($im, $jpg, 85)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } } finally { unset($im); }
            chmod($path, 0600); chmod($jpg, 0600); $pages[] = $validator->inspect($jpg, basename($jpg), 'image/jpeg');
        }
        return ['pages' => $pages, 'sizes' => $sizes];
    }
}
