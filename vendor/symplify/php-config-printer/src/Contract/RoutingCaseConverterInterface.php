<?php

declare (strict_types=1);
namespace ConfigTransformer202110022\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202110022\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110022\PhpParser\Node\Stmt\Expression;
}
