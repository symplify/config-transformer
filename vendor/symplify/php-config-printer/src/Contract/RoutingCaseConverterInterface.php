<?php

declare (strict_types=1);
namespace ConfigTransformer202205214\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202205214\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202205214\PhpParser\Node\Stmt\Expression;
}
