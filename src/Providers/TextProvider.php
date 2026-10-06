<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
interface TextProvider
{
    public function scanText(string $text): \ContentFirewall\Domain\ProviderResult;
}
