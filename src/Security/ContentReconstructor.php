<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
use ContentFirewall\Domain\FileDescriptor;
interface ContentReconstructor
{
    /** @return list<string> */
    public function supportedMimes(): array;
    /** Creates a separate derivative; never modifies the source. */
    public function reconstruct(FileDescriptor $source, string $destination): void;
}
