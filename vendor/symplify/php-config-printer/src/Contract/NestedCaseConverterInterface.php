<?php

declare (strict_types=1);
namespace ConfigTransformer202109040\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202109040\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109040\PhpParser\Node\Stmt\Expression;
}
