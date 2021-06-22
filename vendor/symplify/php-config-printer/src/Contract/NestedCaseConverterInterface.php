<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021062210\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021062210\PhpParser\Node\Stmt\Expression;
}
