<?php

declare (strict_types=1);
namespace ConfigTransformer2021091810\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021091810\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021091810\PhpParser\Node\Stmt\Expression;
}
