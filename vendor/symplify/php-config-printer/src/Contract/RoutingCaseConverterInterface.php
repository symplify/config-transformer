<?php

declare (strict_types=1);
namespace ConfigTransformer202206044\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202206044\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202206044\PhpParser\Node\Stmt\Expression;
}
