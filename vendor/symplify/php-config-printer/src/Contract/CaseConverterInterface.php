<?php

declare (strict_types=1);
namespace ConfigTransformer202203257\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202203257\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202203257\PhpParser\Node\Stmt\Expression;
}
