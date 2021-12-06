<?php

declare (strict_types=1);
namespace ConfigTransformer202112066\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202112066\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer202112066\PhpParser\Node\Stmt\Expression;
}
