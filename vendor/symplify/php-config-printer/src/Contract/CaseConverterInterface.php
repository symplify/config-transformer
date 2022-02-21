<?php

declare (strict_types=1);
namespace ConfigTransformer202202213\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202202213\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202202213\PhpParser\Node\Stmt\Expression;
}
