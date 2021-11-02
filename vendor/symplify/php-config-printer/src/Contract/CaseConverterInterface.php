<?php

declare (strict_types=1);
namespace ConfigTransformer202111023\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202111023\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202111023\PhpParser\Node\Stmt\Expression;
}
