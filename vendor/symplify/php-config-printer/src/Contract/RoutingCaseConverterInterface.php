<?php

declare (strict_types=1);
namespace ConfigTransformer202112236\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202112236\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202112236\PhpParser\Node\Stmt\Expression;
}
