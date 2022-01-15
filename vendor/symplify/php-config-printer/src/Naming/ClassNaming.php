<?php

declare (strict_types=1);
namespace ConfigTransformer202201152\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202201152\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202201152\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
