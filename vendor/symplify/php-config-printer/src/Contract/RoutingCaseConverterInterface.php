<?php

declare (strict_types=1);
namespace ConfigTransformer2021082910\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021082910\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021082910\PhpParser\Node\Stmt\Expression;
}
