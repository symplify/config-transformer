<?php

declare (strict_types=1);
namespace ConfigTransformer2021070710\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021070710\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021070710\PhpParser\Node\Stmt\Expression;
}
