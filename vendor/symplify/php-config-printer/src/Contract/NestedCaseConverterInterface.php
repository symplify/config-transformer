<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021061810\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021061810\PhpParser\Node\Stmt\Expression;
}
