<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022041410\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022041410\PhpParser\Node\Stmt\Expression;
}
