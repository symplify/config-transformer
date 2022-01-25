<?php

declare (strict_types=1);
namespace ConfigTransformer2022012510\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022012510\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2022012510\PhpParser\Node\Stmt\Expression;
}
