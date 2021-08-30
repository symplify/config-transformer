<?php

declare (strict_types=1);
namespace ConfigTransformer202108301\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108301\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108301\PhpParser\Node\Stmt\Expression;
}
