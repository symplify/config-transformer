<?php

declare (strict_types=1);
namespace ConfigTransformer202108315\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108315\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108315\PhpParser\Node\Stmt\Expression;
}
