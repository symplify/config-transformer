<?php

declare (strict_types=1);
namespace ConfigTransformer202202180\Symplify\PhpConfigPrinter\Naming;

use ConfigTransformer202202180\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\strpos($class, '\\') !== \false) {
            return (string) \ConfigTransformer202202180\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
