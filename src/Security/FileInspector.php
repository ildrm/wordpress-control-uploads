<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
use ContentFirewall\Domain\FileDescriptor;
final class FileInspector
{
    private const TYPES = ['jpg' => ['image/jpeg'], 'jpeg' => ['image/jpeg'], 'png' => ['image/png'], 'gif' => ['image/gif'], 'webp' => ['image/webp'], 'avif' => ['image/avif'], 'svg' => ['image/svg+xml', 'text/xml', 'application/xml', 'text/plain'], 'pdf' => ['application/pdf'], 'zip' => ['application/zip'], 'docx' => ['application/zip', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'], 'xlsx' => ['application/zip', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'], 'pptx' => ['application/zip', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'], 'mp3' => ['audio/mpeg'], 'wav' => ['audio/x-wav', 'audio/wav'], 'ogg' => ['audio/ogg', 'video/ogg'], 'm4a' => ['audio/mp4', 'video/mp4'], 'mp4' => ['video/mp4'], 'webm' => ['video/webm'], 'txt' => ['text/plain']];
    /** @param list<string> $allowed */
    public function __construct(private int $maxBytes = 52428800, private int $maxPixels = 24000000, private array $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'pdf', 'txt']) {}
    public function inspect(string $path, string $name, string $declared = ''): FileDescriptor
    {
        if ($name === '' || strlen($name) > 240 || preg_match('/[\x00-\x1f\x7f\/\\\\]/', $name) || $name === '.' || str_contains($name, '..') || preg_match('/\.(php\d*|phtml|phar|exe|com|bat|cmd|js|html?|shtml|sh|cgi|pl|py|asp[x]?)(\.|$)/i', $name)) { throw new \RuntimeException('SECURITY.FILENAME'); }
        if (!is_file($path) || is_link($path) || !is_readable($path)) { throw new \RuntimeException('STORAGE.INPUT'); }
        $bytes = filesize($path);
        if ($bytes === false || $bytes < 1 || $bytes > $this->maxBytes) { throw new \RuntimeException('VALIDATION.SIZE'); }
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION)); $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($path);
        if (!is_string($mime) || !isset(self::TYPES[$ext]) || !in_array($ext, $this->allowed, true) || !in_array($mime, self::TYPES[$ext], true)) { throw new \RuntimeException('SECURITY.TYPE_MISMATCH'); }
        // Browser MIME is advisory; conflicting specific declarations are rejected.
        if ($declared && $declared !== 'application/octet-stream' && !in_array($declared, self::TYPES[$ext], true)) { throw new \RuntimeException('SECURITY.DECLARED_TYPE'); }
        $width = $height = 0;
        if (str_starts_with($mime, 'image/') && $ext !== 'svg') {
            $size = @getimagesize($path);
            if (!$size || !isset($size['mime']) || $size['mime'] !== $mime || $size[0] < 1 || $size[1] < 1) { throw new \RuntimeException('SECURITY.IMAGE_HEADER'); }
            [$width, $height] = $size;
            if ($width > 16000 || $height > 16000 || $width > intdiv($this->maxPixels, $height)) { throw new \RuntimeException('SECURITY.PIXEL_LIMIT'); }
        }
        $hash = hash_file('sha256', $path);
        if ($hash === false) { throw new \RuntimeException('STORAGE.HASH'); }
        return new FileDescriptor($path, $name, $ext === 'svg' ? 'image/svg+xml' : $mime, $bytes, $hash, $width, $height);
    }
}
