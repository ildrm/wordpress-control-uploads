<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Security;
use ContentFirewall\Security\{ArchiveInspector, FileInspector, PrivateStorage, SvgSanitizer, UrlGuard};
use ContentFirewall\Media\ImageProcessor;
use PHPUnit\Framework\TestCase;
final class FileSecurityTest extends TestCase
{
    private string $dir;
    protected function setUp(): void { $this->dir = sys_get_temp_dir() . '/cf-test-' . bin2hex(random_bytes(6)); mkdir($this->dir, 0700); }
    protected function tearDown(): void { $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST); foreach ($iterator as $file) { $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname()); } rmdir($this->dir); }
    private function image(): string { $path = $this->dir . '/valid.png'; $image = imagecreatetruecolor(20, 10); imagefill($image, 0, 0, imagecolorallocate($image, 50, 120, 200)); imagepng($image, $path); unset($image); return $path; }
    public function testTypeMismatch(): void { $this->expectException(\RuntimeException::class); (new FileInspector())->inspect($this->image(), 'fake.jpg'); }
    public function testDangerousFilenameCannotBeNormalizedIntoAcceptance(): void { foreach (['../a.png', 'x.php.png', "x\0.png", str_repeat('x', 241) . '.png', 'a\\b.png'] as $name) { try { (new FileInspector())->inspect($this->image(), $name); self::fail($name); } catch (\RuntimeException $e) { self::assertSame('SECURITY.FILENAME', $e->getMessage()); } } }
    public function testZeroBytes(): void { file_put_contents($this->dir . '/empty', ''); $this->expectException(\RuntimeException::class); (new FileInspector())->inspect($this->dir . '/empty', 'empty.png'); }
    public function testPixelBombRejectedBeforeDecode(): void
    {
        $file = $this->image(); $bytes = file_get_contents($file); $bytes = substr_replace($bytes, pack('NN', 100000, 100000), 16, 8); file_put_contents($file, $bytes); $this->expectException(\RuntimeException::class); (new FileInspector())->inspect($file, 'bomb.png');
    }
    public function testUnicodeNameAndStreamingHash(): void { $path = $this->image(); $descriptor = (new FileInspector())->inspect($path, 'تصویر.png'); self::assertSame(hash_file('sha256', $path), $descriptor->sha256); self::assertSame(20, $descriptor->width); }
    public function testReencodingRemovesPolyglotTrailer(): void
    {
        $path = $this->image(); file_put_contents($path, '<?php harmless_fixture();', FILE_APPEND); $file = (new FileInspector())->inspect($path, 'safe.png'); $out = $this->dir . '/safe.png'; (new ImageProcessor())->reencode($file, $out); self::assertStringNotContainsString('<?php', file_get_contents($out)); self::assertSame('image/png', (new \finfo(FILEINFO_MIME_TYPE))->file($out));
    }
    public function testSvgNeverRetainsActiveOrExternalContent(): void
    {
        $safe = (new SvgSanitizer())->sanitize('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><script>harmless</script><foreignObject/><image xlink:href="https://example.org"/><rect onload="harmless()" style="fill:url(https://example.org)" fill="url(https://example.org)" width="5"/><?bad instruction?></svg>');
        foreach (['script','foreignObject','href','onload','style','url(','instruction'] as $forbidden) { self::assertStringNotContainsString($forbidden, $safe); } self::assertStringContainsString('rect', $safe);
    }
    public function testSvgEntityRejected(): void { $this->expectException(\RuntimeException::class); (new SvgSanitizer())->sanitize('<!DOCTYPE svg [<!ENTITY x SYSTEM "file:///etc/passwd">]><svg xmlns="http://www.w3.org/2000/svg">&x;</svg>'); }
    public function testArchiveTraversalAndBomb(): void
    {
        foreach (['../bad.txt', 'safe.txt'] as $entry) { $path = $this->dir . '/test.zip'; $zip = new \ZipArchive(); $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE); $zip->addFromString($entry, str_repeat('A', 200000)); $zip->close(); try { (new ArchiveInspector())->inspect($path); self::fail('Archive accepted'); } catch (\RuntimeException $e) { self::assertStringStartsWith('SECURITY.ARCHIVE_', $e->getMessage()); } }
    }
    public function testPrivateStorageTenantIsolationAndIntegrity(): void
    {
        $store = new PrivateStorage($this->dir . '/private'); $path = $this->image(); $id = $store->put($path, 1, hash_file('sha256', $path)); self::assertSame(0, fileperms($store->path($id, 1)) & 0077); $this->expectException(\RuntimeException::class); $store->path($id, 2);
    }
    public function testPrivateStorageRejectsPublicRoot(): void { $this->expectException(\RuntimeException::class); new PrivateStorage($this->dir . '/uploads', [$this->dir]); }
    public function testPrivateAndMappedIpsRejected(): void { foreach (['127.0.0.1','10.0.0.1','169.254.169.254','192.168.1.1','::1','fc00::1','fe80::1','::ffff:127.0.0.1','100.65.0.1'] as $ip) { self::assertFalse(UrlGuard::publicIp($ip), $ip); } self::assertTrue(UrlGuard::publicIp('8.8.8.8')); }
    public function testPerceptualFingerprintDistance(): void { $file = (new FileInspector())->inspect($this->image(), 'valid.png'); $hash = (new ImageProcessor())->fingerprint($file); self::assertSame(0, ImageProcessor::distance($hash, $hash)); self::assertSame(64, ImageProcessor::distance('0000000000000000', 'ffffffffffffffff')); }
}
