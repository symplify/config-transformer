<?php

declare (strict_types=1);
namespace ConfigTransformer202107101\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202107101\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202107101\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
