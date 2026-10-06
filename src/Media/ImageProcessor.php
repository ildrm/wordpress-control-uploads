<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\FileDescriptor;
final class ImageProcessor
{
    /** Bounded GD re-encode strips all ancillary metadata and active polyglot trailers. */
    public function reencode(FileDescriptor $file, string $destination, int $maxSide = 2048, array $regions = []): void
    {
        if (!$file->width || !$file->height || $file->width * $file->height > 24000000 || count($regions) > 100) { throw new \RuntimeException('SECURITY.IMAGE_RESOURCE'); }
        $limit = self::memoryLimit(); $estimate = $file->width * $file->height * 12 + $file->bytes + 16777216;
        if ($limit > 0 && memory_get_usage(true) + $estimate > $limit) { throw new \RuntimeException('SECURITY.DECODE_MEMORY'); }
        $image = match ($file->mime) { 'image/jpeg' => @imagecreatefromjpeg($file->path), 'image/png' => @imagecreatefrompng($file->path), 'image/webp' => @imagecreatefromwebp($file->path), 'image/gif' => @imagecreatefromgif($file->path), 'image/avif' => function_exists('imagecreatefromavif') ? @imagecreatefromavif($file->path) : false, default => false };
        if (!$image) { throw new \RuntimeException('SECURITY.IMAGE_DECODE'); }
        try {
            foreach ($regions as $region) {
                if (count($region) !== 4 || min($region) < 0 || max($region) > 1 || $region[0] + $region[2] > 1 || $region[1] + $region[3] > 1) { throw new \RuntimeException('PRIVACY.REGION'); }
                imagefilledrectangle($image, (int)floor($region[0] * $file->width), (int)floor($region[1] * $file->height), (int)ceil(($region[0] + $region[2]) * $file->width), (int)ceil(($region[1] + $region[3]) * $file->height), imagecolorallocate($image, 0, 0, 0));
            }
            if ($maxSide > 0 && max($file->width, $file->height) > $maxSide) {
                $ratio = $maxSide / max($file->width, $file->height); $scaled = imagescale($image, max(1, (int)round($file->width * $ratio)), max(1, (int)round($file->height * $ratio)));
                if (!$scaled) { throw new \RuntimeException('SECURITY.IMAGE_SCALE'); } unset($image); $image = $scaled;
            }
            imagealphablending($image, false); imagesavealpha($image, true);
            $ok = match ($file->mime) { 'image/jpeg' => imagejpeg($image, $destination, 90), 'image/png' => imagepng($image, $destination, 6), 'image/webp' => imagewebp($image, $destination, 90), 'image/gif' => imagegif($image, $destination), 'image/avif' => function_exists('imageavif') && imageavif($image, $destination, 90), default => false };
            if (!$ok) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } chmod($destination, 0600);
        } finally { unset($image); }
    }
    private static function memoryLimit(): int
    {
        $value = ini_get('memory_limit'); if (!$value || $value === '-1') { return 0; }
        return (int)$value * match (strtolower(substr($value, -1))) { 'g' => 1073741824, 'm' => 1048576, 'k' => 1024, default => 1 };
    }
    public function fingerprint(FileDescriptor $file): string
    {
        if ($file->width * $file->height > 4000000 || $file->bytes > 5242880) { throw new \RuntimeException('SECURITY.FINGERPRINT_RESOURCE'); }
        $image = @imagecreatefromstring((string)file_get_contents($file->path)); if (!$image) { throw new \RuntimeException('VALIDATION.IMAGE'); }
        $small = imagescale($image, 9, 8); unset($image);
        if (!$small) { throw new \RuntimeException('VALIDATION.IMAGE'); }
        try {
            $bits = ''; for ($y = 0; $y < 8; $y++) { for ($x = 0; $x < 8; $x++) { $a = imagecolorsforindex($small, imagecolorat($small, $x, $y)); $b = imagecolorsforindex($small, imagecolorat($small, $x + 1, $y)); $bits .= ($a['red'] * 0.299 + $a['green'] * 0.587 + $a['blue'] * 0.114) > ($b['red'] * 0.299 + $b['green'] * 0.587 + $b['blue'] * 0.114) ? '1' : '0'; } }
            $hex = ''; foreach (str_split($bits, 4) as $nibble) { $hex .= dechex(bindec($nibble)); } return $hex;
        } finally { unset($small); }
    }
    public static function distance(string $a, string $b): int
    {
        if (!preg_match('/^[a-f0-9]{16}$/D', $a) || !preg_match('/^[a-f0-9]{16}$/D', $b)) { throw new \InvalidArgumentException('VALIDATION.FINGERPRINT'); }
        $distance = 0; for ($i = 0; $i < 16; $i++) { $distance += substr_count(decbin(hexdec($a[$i]) ^ hexdec($b[$i])), '1'); } return $distance;
    }
}
