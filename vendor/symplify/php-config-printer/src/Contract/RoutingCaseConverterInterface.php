<?php

declare (strict_types=1);
namespace ConfigTransformer202109299\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202109299\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109299\PhpParser\Node\Stmt\Expression;
}
