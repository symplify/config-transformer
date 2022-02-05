<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022020510\PhpParser\Node\Stmt\Expression;
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
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022020510\PhpParser\Node\Stmt\Expression;
}
