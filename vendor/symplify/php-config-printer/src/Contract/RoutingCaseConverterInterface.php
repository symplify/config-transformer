<?php

declare (strict_types=1);
namespace ConfigTransformer202107081\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202107081\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202107081\PhpParser\Node\Stmt\Expression;
}
