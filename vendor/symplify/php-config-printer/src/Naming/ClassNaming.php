<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer2022041410\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer2022041410\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
