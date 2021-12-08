<?php

declare (strict_types=1);
namespace ConfigTransformer2021120810\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer2021120810\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer2021120810\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
