<?php

declare (strict_types=1);
namespace ConfigTransformer202109131\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202109131\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109131\PhpParser\Node\Stmt\Expression;
}
