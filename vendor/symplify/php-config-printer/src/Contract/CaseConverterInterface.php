<?php

declare (strict_types=1);
namespace ConfigTransformer202110314\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202110314\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110314\PhpParser\Node\Stmt\Expression;
}
