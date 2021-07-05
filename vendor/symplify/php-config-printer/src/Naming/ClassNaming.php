<?php

declare (strict_types=1);
namespace ConfigTransformer202107050\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202107050\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202107050\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
