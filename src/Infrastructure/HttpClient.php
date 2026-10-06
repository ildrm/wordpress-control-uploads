<?php
declare(strict_types=1);
namespace ContentFirewall\Infrastructure;
interface HttpClient
{
    /** @return array{status:int,body:string,headers:array} */
    public function request(string $url, array $headers, string $body, int $timeoutMs = 1500): array;
}
