<?php

declare (strict_types=1);
namespace ConfigTransformer202110312\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202110312\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param mixed $values
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110312\PhpParser\Node\Stmt\Expression;
}
