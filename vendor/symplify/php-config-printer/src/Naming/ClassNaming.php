<?php

declare (strict_types=1);
namespace ConfigTransformer2021092210\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer2021092210\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer2021092210\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
