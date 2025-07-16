<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract;

use ConfigTransformerPrefix202507\PhpParser\Node\Stmt;
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
    public function convertToMethodCallStmt($key, $values) : Stmt;
}
