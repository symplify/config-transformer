<?php

declare (strict_types=1);
namespace ConfigTransformer202107081\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202107081\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202107081\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
