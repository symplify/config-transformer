<?php

declare (strict_types=1);
namespace ConfigTransformer202111107\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202111107\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202111107\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
