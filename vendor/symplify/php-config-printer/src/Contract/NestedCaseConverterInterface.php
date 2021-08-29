<?php

declare (strict_types=1);
namespace ConfigTransformer2021082910\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021082910\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021082910\PhpParser\Node\Stmt\Expression;
}
