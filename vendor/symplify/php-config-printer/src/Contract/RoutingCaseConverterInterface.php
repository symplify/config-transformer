<?php

declare (strict_types=1);
namespace ConfigTransformer202107138\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202107138\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107138\PhpParser\Node\Stmt\Expression;
}
