<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\{FileDescriptor, Policy, ProviderResult};
use ContentFirewall\Infrastructure\ProcessRunner;
use ContentFirewall\Security\{FileInspector, PrivateStorage};
use ContentFirewall\Policy\EvidenceCoverage;
final class TemporalMedia
{
    public function __construct(private string $ffmpeg, private string $ffprobe, private PrivateStorage $storage, private int $siteId, private array $limits, private ProcessRunner $runner = new ProcessRunner()) {}
    public function configured(): bool { return $this->ffmpeg !== '' && $this->ffprobe !== ''; }
    public function probe(FileDescriptor $file): array
    {
        if (!hash_equals($file->sha256, (string)hash_file('sha256', $file->path))) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        $reply = $this->runner->run([$this->ffprobe, '-v', 'error', '-protocol_whitelist', 'file,pipe', '-format_whitelist', 'mov,matroska,webm,mp3,wav,ogg', '-show_entries', 'format=duration:stream=codec_type,width,height', '-of', 'json', $file->path], dirname($file->path), 15000, 16384);
        if ($reply['exit_code'] !== 0) { throw new \RuntimeException('SECURITY.MEDIA_STRUCTURE'); }
        try { $value = json_decode($reply['stdout'], true, 16, JSON_THROW_ON_ERROR); }
        catch (\JsonException) { throw new \RuntimeException('SECURITY.MEDIA_STRUCTURE'); }
        if (!is_array($value)) { throw new \RuntimeException('SECURITY.MEDIA_STRUCTURE'); } $duration = $value['format']['duration'] ?? null;
        if (!is_numeric($duration) || !is_finite((float)$duration) || $duration <= 0 || $duration > $this->limits['max_duration'] || !is_array($value['streams'] ?? null) || count($value['streams']) > 10) { throw new \RuntimeException('SECURITY.MEDIA_DURATION'); }
        $video = $audio = false; $width = $height = 0;
        foreach ($value['streams'] as $stream) {
            if (($stream['codec_type'] ?? '') === 'video') {
                if ($video || !is_int($stream['width'] ?? null) || !is_int($stream['height'] ?? null) || $stream['width'] < 1 || $stream['height'] < 1 || $stream['width'] > 16000 || $stream['height'] > 16000 || $stream['width'] > intdiv(24000000, $stream['height'])) { throw new \RuntimeException('SECURITY.PIXEL_LIMIT'); }
                $video = true; $width = $stream['width']; $height = $stream['height'];
            }
            if (($stream['codec_type'] ?? '') === 'audio') { $audio = true; }
        }
        $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
        if ((!$video && !$audio) || (in_array($extension, ['mp4', 'webm'], true) && !$video) || (in_array($extension, ['mp3', 'wav', 'm4a', 'ogg'], true) && $video)) { throw new \RuntimeException('SECURITY.MEDIA_STRUCTURE'); }
        return ['duration' => (float)$duration, 'width' => $width, 'height' => $height, 'has_audio' => $audio, 'has_video' => $video];
    }
    /** @param callable(FileDescriptor):list<ProviderResult> $scan @return array{results:array,signals:array} */
    public function inspect(FileDescriptor $file, Policy $policy, callable $scan, array $priorFindings = [], array $priorSignals = []): array
    {
        $signals = $this->probe($file); $workspace = $this->storage->workspace($this->siteId); $results = []; $incomplete = false; $frames = 0;
        try {
            if ($signals['has_video'] && ($policy->options['requires_content'] ?? false)) {
                $interval = max(0.1, $signals['duration'] / $this->limits['max_frames']); $number = sprintf('%.6F', $interval);
                $select = match ($this->limits['sampling']) { 'scene' => "select=eq(n\\,0)+gt(scene\\,0.25)", 'adaptive' => "select=eq(n\\,0)+gte(t-prev_selected_t\\," . $number . ")+gt(scene\\,0.25)", default => 'fps=1/' . $number };
                $filter = $select . ',scale=w=min(1024\\,iw):h=-2';
                $this->execute(['-i', $file->path, '-an', '-vf', $filter, '-fps_mode', 'vfr', '-frames:v', (string)$this->limits['max_frames'], '-q:v', '4', $workspace . '/frame-%03d.jpg'], $workspace);
                $validator = new FileInspector(5242880, 4194304, ['jpg']);
                foreach (glob($workspace . '/frame-*.jpg') ?: [] as $path) {
                    $frame = $validator->inspect($path, basename($path), 'image/jpeg'); chmod($path, 0600); $part = $scan($frame); $results = array_merge($results, $part); $frames++;
                    if ($policy->options['requires_content'] ?? false) {
                        $findings = $priorFindings; $ok = false; $frameSignals = $priorSignals;
                        foreach ($part as $result) { if (!$result->error) { $ok = true; $findings = array_merge($findings, $result->findings); if ($result->text !== '') { $frameSignals['ocr_text'] = $result->text; $findings = array_merge($findings, (new \ContentFirewall\Privacy\TextInspector())->inspect($result->text, $policy->options['patterns'] ?? [])); } } }
                        $incomplete = $incomplete || !$ok || (bool)EvidenceCoverage::missing($policy, $findings, $frameSignals) || EvidenceCoverage::consensusIncomplete($policy, $part);
                    }
                }
                if (!$frames) { throw new \RuntimeException('SECURITY.MEDIA_FRAMES'); }
            }
            if ($signals['has_audio'] && ($policy->options['requires_content'] ?? false)) {
                $this->execute(['-i', $file->path, '-vn', '-ac', '1', '-ar', '16000', '-c:a', 'libmp3lame', '-b:a', '64k', '-map_metadata', '-1', '-map_chapters', '-1', '-f', 'segment', '-segment_time', '30', '-segment_format', 'mp3', $workspace . '/audio-%03d.mp3'], $workspace);
                $parts = glob($workspace . '/audio-*.mp3') ?: []; if (!$parts || count($parts) > 21) { throw new \RuntimeException('SECURITY.MEDIA_DURATION'); }
                foreach ($parts as $path) {
                    $audio = (new FileInspector(5242880, 24000000, ['mp3']))->inspect($path, 'audio.mp3', 'audio/mpeg'); chmod($path, 0600); $part = $scan($audio); $results = array_merge($results, $part);
                    if (!array_filter($part, static fn(ProviderResult $r): bool => !$r->error && $r->text !== '')) { $incomplete = true; }
                }
            }
            $signals['sample_count'] = $frames; $signals['sampling'] = $this->limits['sampling']; $signals['media_coverage_incomplete'] = $incomplete;
            // Security-only video with no soundtrack still has measured local structure evidence.
            if (!$results && !($policy->options['requires_content'] ?? false)) { $results[] = new ProviderResult('local-media', '1', []); }
            return ['results' => ResultAccumulator::merge($results), 'signals' => $signals];
        } finally { $this->storage->removeWorkspace($workspace, $this->siteId); }
    }
    public function reconstruct(FileDescriptor $file, string $destination, array $regions = []): void
    {
        $info = $this->probe($file); $workspace = $this->storage->workspace($this->siteId); $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION)); $output = $workspace . '/clean.' . $extension;
        try {
            $args = ['-i', $file->path, '-map_metadata', '-1', '-map_chapters', '-1'];
            if ($info['has_video']) {
                $filters = [];
                foreach ($regions as $region) { new \ContentFirewall\Domain\Finding('privacy.mask', 1, region: $region); $filters[] = sprintf('drawbox=x=iw*%.8F:y=ih*%.8F:w=iw*%.8F:h=ih*%.8F:color=black:t=fill', ...$region); }
                if ($filters) { $args = array_merge($args, ['-vf', implode(',', $filters)]); }
                $args = array_merge($args, ['-map', '0:v:0', '-map', '0:a:0?', '-c:v', $extension === 'webm' ? 'libvpx-vp9' : 'libx264', '-c:a', $extension === 'webm' ? 'libopus' : 'aac', '-f', $extension === 'webm' ? 'webm' : 'mp4']);
            } else {
                $codec = match ($extension) { 'mp3' => 'libmp3lame', 'wav' => 'pcm_s16le', 'ogg' => 'libvorbis', 'm4a' => 'aac', default => throw new \RuntimeException('SECURITY.MEDIA_STRUCTURE') };
                $args = array_merge($args, ['-vn', '-map', '0:a:0', '-c:a', $codec, '-f', $extension === 'm4a' ? 'ipod' : $extension]);
            }
            $this->execute(array_merge($args, ['-fs', '104857601', $output]), $workspace);
            if (!is_file($output) || filesize($output) < 1 || filesize($output) > 104857600 || !copy($output, $destination)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); }
            $checked = (new FileInspector(104857600, 24000000, [$extension]))->inspect($output, $file->name, $file->mime); $decoded = $this->probe($checked);
            if (abs($decoded['duration'] - $info['duration']) > max(0.5, $info['duration'] * 0.01) || $decoded['has_video'] !== $info['has_video'] || $decoded['has_audio'] !== $info['has_audio']) { throw new \RuntimeException('SECURITY.MEDIA_INCOMPLETE'); }
            chmod($destination, 0600);
        } finally { $this->storage->removeWorkspace($workspace, $this->siteId); }
    }
    private function execute(array $args, string $workspace): void
    {
        $output = array_pop($args);
        $reply = $this->runner->run(array_merge([$this->ffmpeg, '-nostdin', '-hide_banner', '-loglevel', 'error', '-y', '-max_alloc', '67108864', '-protocol_whitelist', 'file,pipe', '-format_whitelist', 'mov,matroska,webm,mp3,wav,ogg', '-threads', '1', '-filter_threads', '1'], $args, ['-threads', '1', '-t', (string)$this->limits['max_duration'], $output]), $workspace, 90000, 16384);
        if ($reply['exit_code'] !== 0) { throw new \RuntimeException('SECURITY.MEDIA_PROCESSING'); }
    }
}
