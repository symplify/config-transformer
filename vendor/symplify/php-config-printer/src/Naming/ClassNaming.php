<?php

declare (strict_types=1);
namespace ConfigTransformer202202215\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202202215\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202202215\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
