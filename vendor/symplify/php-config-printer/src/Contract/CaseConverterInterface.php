<?php

declare (strict_types=1);
namespace ConfigTransformer2021120710\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021120710\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    /**
     * @param mixed $key
     * @param mixed $values
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021120710\PhpParser\Node\Stmt\Expression;
}
