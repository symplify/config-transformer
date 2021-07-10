<?php

declare (strict_types=1);
namespace ConfigTransformer202107107\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202107107\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107107\PhpParser\Node\Stmt\Expression;
}
