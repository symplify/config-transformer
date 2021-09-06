<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021090610\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021090610\PhpParser\Node\Stmt\Expression;
}
