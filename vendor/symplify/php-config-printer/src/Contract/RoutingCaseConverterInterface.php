<?php

declare (strict_types=1);
namespace ConfigTransformer2021093010\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021093010\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021093010\PhpParser\Node\Stmt\Expression;
}
