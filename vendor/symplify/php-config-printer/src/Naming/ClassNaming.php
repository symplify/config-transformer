<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer2022020510\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer2022020510\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
