<?php

declare (strict_types=1);
namespace ConfigTransformer202112237\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202112237\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202112237\PhpParser\Node\Stmt\Expression;
}
