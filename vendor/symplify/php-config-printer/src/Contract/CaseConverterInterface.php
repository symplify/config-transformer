<?php

declare (strict_types=1);
namespace ConfigTransformer202108294\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108294\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108294\PhpParser\Node\Stmt\Expression;
}
