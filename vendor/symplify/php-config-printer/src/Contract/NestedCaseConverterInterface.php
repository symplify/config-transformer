<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202106110\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106110\PhpParser\Node\Stmt\Expression;
}
