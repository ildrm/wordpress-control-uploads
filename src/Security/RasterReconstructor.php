<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
use ContentFirewall\Domain\FileDescriptor;
final class RasterReconstructor implements ContentReconstructor
{
    public function supportedMimes(): array { return ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif']; }
    public function reconstruct(FileDescriptor $source, string $destination): void
    {
        if ($source->path === $destination || !in_array($source->mime, $this->supportedMimes(), true)) { throw new \RuntimeException('SECURITY.CDR_INPUT'); }
        (new \ContentFirewall\Media\ImageProcessor())->reencode($source, $destination, 0);
    }
}
