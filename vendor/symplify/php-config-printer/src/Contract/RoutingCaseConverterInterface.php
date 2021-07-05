<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021070510\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2021070510\PhpParser\Node\Stmt\Expression;
}
