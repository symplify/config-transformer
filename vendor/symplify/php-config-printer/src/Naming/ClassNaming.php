<?php

declare (strict_types=1);
namespace ConfigTransformer202107103\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202107103\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202107103\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
