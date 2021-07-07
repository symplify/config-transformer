<?php

declare (strict_types=1);
namespace ConfigTransformer202107072\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202107072\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107072\PhpParser\Node\Stmt\Expression;
}
