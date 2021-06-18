<?php

declare (strict_types=1);
namespace ConfigTransformer202106181\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202106181\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106181\PhpParser\Node\Stmt\Expression;
}
