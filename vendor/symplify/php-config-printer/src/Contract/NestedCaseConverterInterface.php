<?php

declare (strict_types=1);
namespace ConfigTransformer202108234\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108234\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108234\PhpParser\Node\Stmt\Expression;
}
