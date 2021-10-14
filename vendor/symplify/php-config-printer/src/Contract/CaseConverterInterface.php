<?php

declare (strict_types=1);
namespace ConfigTransformer202110145\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202110145\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110145\PhpParser\Node\Stmt\Expression;
}
