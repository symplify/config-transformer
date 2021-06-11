<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer2021061110\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\ConfigTransformer2021061110\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \ConfigTransformer2021061110\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
