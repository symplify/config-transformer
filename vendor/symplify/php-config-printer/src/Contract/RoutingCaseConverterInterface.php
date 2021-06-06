<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer20210606\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer20210606\PhpParser\Node\Stmt\Expression;
}
