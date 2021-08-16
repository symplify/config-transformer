<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021081610\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021081610\PhpParser\Node\Stmt\Expression;
}
