<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, ProviderResult};
use ContentFirewall\Infrastructure\HttpClient;
abstract class JsonProvider implements Provider
{
    public function __construct(protected HttpClient $http, protected string $key, protected string $endpoint, protected int $timeoutMs = 1500) {}
    /** @return array{url:string,headers:array,body:string} */
    abstract public function build(FileDescriptor $file): array;
    abstract public function parse(array $data): ProviderResult;
    protected function bytes(FileDescriptor $file): string
    {
        if ($file->bytes > 5242880 || !is_file($file->path)) { throw new \RuntimeException('PROVIDER.INPUT_LIMIT'); }
        $bytes = file_get_contents($file->path);
        if ($bytes === false || !hash_equals($file->sha256, hash('sha256', $bytes))) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        return base64_encode($bytes);
    }
    public function scan(FileDescriptor $file): ProviderResult
    {
        $start = microtime(true);
        try {
            if (!in_array($file->mime, $this->capabilities()['mimes'], true)) { return new ProviderResult($this->id(), $this->capabilities()['model'], [], 'PROVIDER.UNSUPPORTED'); }
            $request = $this->build($file); $reply = $this->http->request($request['url'], $request['headers'], $request['body'], $this->timeoutMs);
            if ($reply['status'] < 200 || $reply['status'] >= 300) { return new ProviderResult($this->id(), $this->capabilities()['model'], [], 'PROVIDER.HTTP_' . $reply['status'], $reply['status'] === 429 || $reply['status'] >= 500, (microtime(true) - $start) * 1000); }
            $data = json_decode($reply['body'], true, 32, JSON_THROW_ON_ERROR);
            if (!is_array($data)) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $result = $this->parse($data);
            return new ProviderResult($result->provider, $result->model, $result->findings, $result->error, $result->retryable, (microtime(true) - $start) * 1000, $result->estimatedCost, $result->text, $result->codes);
        } catch (\Throwable $e) {
            $code = $e instanceof \RuntimeException && preg_match('/^[A-Z]+\.[A-Z_]+$/D', $e->getMessage()) ? $e->getMessage() : 'PROVIDER.SCHEMA';
            return new ProviderResult($this->id(), $this->capabilities()['model'], [], $code, $code === 'PROVIDER.TRANSPORT', (microtime(true) - $start) * 1000);
        }
    }
}
