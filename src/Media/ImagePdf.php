<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\FileDescriptor;
/** A new image-only PDF: no imported source PDF objects, actions, links or attachments. */
final class ImagePdf
{
    /** @param list<FileDescriptor> $pages */
    public function write(array $pages, string $destination, array $sizes = []): void
    {
        if (!$pages || count($pages) > 100 || ($sizes && count($sizes) !== count($pages))) { throw new \RuntimeException('SECURITY.PDF_PAGES'); }
        $stream = fopen($destination, 'wb'); if (!$stream) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
        $offsets = [0];
        $put = static function (string $bytes) use ($stream): void { if (fwrite($stream, $bytes) !== strlen($bytes)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } };
        $object = static function (int $id, string $value) use (&$offsets, $stream, $put): void { $offsets[$id] = ftell($stream); $put($id . " 0 obj\n" . $value . "\nendobj\n"); };
        try {
            $put("%PDF-1.4\n%\xE2\xE3\xCF\xD3\n"); $object(1, '<< /Type /Catalog /Pages 2 0 R >>');
            $children = []; foreach ($pages as $index => $page) { $children[] = (3 + $index * 3) . ' 0 R'; }
            $object(2, '<< /Type /Pages /Count ' . count($pages) . ' /Kids [' . implode(' ', $children) . '] >>');
            foreach ($pages as $index => $page) {
                if ($page->mime !== 'image/jpeg' || $page->width < 1 || $page->height < 1 || $page->bytes > 5242880 || !hash_equals($page->sha256, (string)hash_file('sha256', $page->path))) { throw new \RuntimeException('SECURITY.CDR_OUTPUT'); }
                $base = 3 + $index * 3; $w = $page->width; $h = $page->height; $data = file_get_contents($page->path); if ($data === false) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
                $size = $sizes[$index] ?? [(float)$w, (float)$h];
                if (!array_is_list($size) || count($size) !== 2) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); }
                foreach ($size as $dimension) { if ((!is_int($dimension) && !is_float($dimension)) || !is_finite((float)$dimension) || $dimension < 1 || $dimension > 14400) { throw new \RuntimeException('SECURITY.PDF_STRUCTURE'); } }
                $pw = sprintf('%.4F', $size[0]); $ph = sprintf('%.4F', $size[1]);
                $object($base, '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . $pw . ' ' . $ph . '] /Resources << /XObject << /Image ' . ($base + 1) . ' 0 R >> >> /Contents ' . ($base + 2) . ' 0 R >>');
                $object($base + 1, '<< /Type /XObject /Subtype /Image /Width ' . $w . ' /Height ' . $h . ' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ' . strlen($data) . ">>\nstream\n" . $data . "\nendstream");
                $draw = 'q ' . $pw . ' 0 0 ' . $ph . " 0 0 cm /Image Do Q\n"; $object($base + 2, '<< /Length ' . strlen($draw) . ">>\nstream\n" . $draw . 'endstream');
                if (ftell($stream) > 104857600) { throw new \RuntimeException('VALIDATION.SIZE'); }
            }
            $xref = ftell($stream); $put('xref' . "\n0 " . count($offsets) . "\n0000000000 65535 f \n");
            foreach (array_slice($offsets, 1) as $offset) { $put(sprintf("%010d 00000 n \n", $offset)); }
            $put('trailer << /Size ' . count($offsets) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF\n");
            if (!fflush($stream)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
        } finally { fclose($stream); }
        chmod($destination, 0600);
    }
}
