<?php

declare (strict_types=1);
namespace ConfigTransformer202108302\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108302\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108302\PhpParser\Node\Stmt\Expression;
}
