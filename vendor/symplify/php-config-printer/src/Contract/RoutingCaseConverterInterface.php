<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer202207\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : Expression;
}
