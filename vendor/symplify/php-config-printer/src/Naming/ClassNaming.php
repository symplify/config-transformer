<?php

declare (strict_types=1);
namespace ConfigTransformer202106246\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202106246\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202106246\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
