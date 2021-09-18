<?php

declare (strict_types=1);
namespace ConfigTransformer2021091810\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021091810\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021091810\PhpParser\Node\Stmt\Expression;
}
