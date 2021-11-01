<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021110110\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021110110\PhpParser\Node\Stmt\Expression;
}
