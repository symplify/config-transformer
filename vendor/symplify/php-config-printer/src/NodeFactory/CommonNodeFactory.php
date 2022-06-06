<?php

declare (strict_types=1);
namespace ConfigTransformer202206063\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202206063\PhpParser\BuilderHelpers;
use ConfigTransformer202206063\PhpParser\Node\Expr;
use ConfigTransformer202206063\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer202206063\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202206063\PhpParser\Node\Name;
use ConfigTransformer202206063\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202206063\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202206063\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    /**
     * @param mixed $argument
     */
    public function createAbsoluteDirExpr($argument) : \ConfigTransformer202206063\PhpParser\Node\Expr
    {
        if ($argument === '') {
            return new \ConfigTransformer202206063\PhpParser\Node\Scalar\String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $argumentValue = \ConfigTransformer202206063\PhpParser\BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof \ConfigTransformer202206063\PhpParser\Node\Scalar\String_) {
            $argumentValue = new \ConfigTransformer202206063\PhpParser\Node\Expr\BinaryOp\Concat(new \ConfigTransformer202206063\PhpParser\Node\Scalar\MagicConst\Dir(), $argumentValue);
        }
        return $argumentValue;
    }
    public function createClassReference(string $className) : \ConfigTransformer202206063\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : \ConfigTransformer202206063\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \ConfigTransformer202206063\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer202206063\PhpParser\Node\Name\FullyQualified($className), $constantName);
    }
    public function createFalse() : \ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer202206063\PhpParser\Node\Name('false'));
    }
    public function createTrue() : \ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer202206063\PhpParser\Node\Name('true'));
    }
}
