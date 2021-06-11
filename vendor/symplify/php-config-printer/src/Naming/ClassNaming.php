<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202106110\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\ConfigTransformer202106110\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \ConfigTransformer202106110\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}