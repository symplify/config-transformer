<?php

declare (strict_types=1);
namespace ConfigTransformer202106282\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202106282\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106282\PhpParser\Node\Stmt\Expression;
}
