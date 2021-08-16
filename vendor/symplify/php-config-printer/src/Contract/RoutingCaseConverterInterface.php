<?php

declare (strict_types=1);
namespace ConfigTransformer202108160\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202108160\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108160\PhpParser\Node\Stmt\Expression;
}
