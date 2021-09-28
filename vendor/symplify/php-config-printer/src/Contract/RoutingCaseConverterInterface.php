<?php

declare (strict_types=1);
namespace ConfigTransformer202109284\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202109284\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109284\PhpParser\Node\Stmt\Expression;
}
