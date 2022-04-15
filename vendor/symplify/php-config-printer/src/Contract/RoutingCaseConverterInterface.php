<?php

declare (strict_types=1);
namespace ConfigTransformer202204152\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202204152\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202204152\PhpParser\Node\Stmt\Expression;
}
