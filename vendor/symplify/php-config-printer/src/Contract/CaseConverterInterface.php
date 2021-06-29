<?php

declare (strict_types=1);
namespace ConfigTransformer202106299\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202106299\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106299\PhpParser\Node\Stmt\Expression;
}
