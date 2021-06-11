<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression;
}
