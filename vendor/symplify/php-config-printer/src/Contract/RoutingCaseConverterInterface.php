<?php

declare (strict_types=1);
namespace ConfigTransformer202109236\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202109236\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109236\PhpParser\Node\Stmt\Expression;
}
