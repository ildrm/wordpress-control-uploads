<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class FileDescriptor
{
    public function __construct(public string $path, public string $name, public string $mime, public int $bytes, public string $sha256, public int $width = 0, public int $height = 0) {}
    public function signals(): array { return ['mime' => $this->mime, 'extension' => strtolower(pathinfo($this->name, PATHINFO_EXTENSION)), 'bytes' => $this->bytes, 'width' => $this->width, 'height' => $this->height, 'pixels' => $this->width * $this->height, 'aspect_ratio' => $this->height ? $this->width / $this->height : 0]; }
}
