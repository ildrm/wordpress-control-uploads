<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
use ContentFirewall\Domain\FileDescriptor;
final class SvgReconstructor implements ContentReconstructor
{
    public function supportedMimes(): array { return ['image/svg+xml']; }
    public function reconstruct(FileDescriptor $source, string $destination): void
    {
        if ($source->path === $destination || $source->mime !== 'image/svg+xml' || $source->bytes > 1048576) { throw new \RuntimeException('SECURITY.CDR_INPUT'); }
        $safe = (new SvgSanitizer())->sanitize((string)file_get_contents($source->path));
        if (file_put_contents($destination, $safe) === false) { throw new \RuntimeException('STORAGE.CDR_OUTPUT'); } chmod($destination, 0600);
    }
}
