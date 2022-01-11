<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022011110\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2022011110\PhpParser\Node\Stmt\Expression;
}
