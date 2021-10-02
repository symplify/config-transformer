<?php

declare (strict_types=1);
namespace ConfigTransformer202110029\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202110029\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110029\PhpParser\Node\Stmt\Expression;
}
