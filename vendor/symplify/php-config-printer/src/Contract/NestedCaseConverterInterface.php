<?php

declare (strict_types=1);
namespace ConfigTransformer202106205\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202106205\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106205\PhpParser\Node\Stmt\Expression;
}
