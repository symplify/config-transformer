<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021122310\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2021122310\PhpParser\Node\Stmt\Expression;
}
