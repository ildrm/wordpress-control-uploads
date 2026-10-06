<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, ProviderResult};
interface Provider
{
    public function id(): string;
    /** @return array{features:list<string>,mimes:list<string>,regions:list<string>,model:string,cacheable?:bool} */
    public function capabilities(): array;
    public function scan(FileDescriptor $file): ProviderResult;
}
