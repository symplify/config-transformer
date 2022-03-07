<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022030710\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022030710\PhpParser\Node\Stmt\Expression;
}
