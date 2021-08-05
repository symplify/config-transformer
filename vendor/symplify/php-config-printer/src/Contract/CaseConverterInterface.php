<?php

declare (strict_types=1);
namespace ConfigTransformer2021080510\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021080510\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021080510\PhpParser\Node\Stmt\Expression;
}
