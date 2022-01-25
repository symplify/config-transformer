<?php

declare (strict_types=1);
namespace ConfigTransformer202201257\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202201257\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202201257\PhpParser\Node\Stmt\Expression;
}
