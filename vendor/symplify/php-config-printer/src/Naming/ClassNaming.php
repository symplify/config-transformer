<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use ConfigTransformerPrefix202312\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
