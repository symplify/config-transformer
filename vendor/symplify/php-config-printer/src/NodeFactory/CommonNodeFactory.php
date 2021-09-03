<?php

declare (strict_types=1);
namespace ConfigTransformer202109036\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202109036\PhpParser\BuilderHelpers;
use ConfigTransformer202109036\PhpParser\Node\Expr;
use ConfigTransformer202109036\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer202109036\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202109036\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202109036\PhpParser\Node\Name;
use ConfigTransformer202109036\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202109036\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202109036\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    public function createAbsoluteDirExpr($argument) : \ConfigTransformer202109036\PhpParser\Node\Expr
    {
        if ($argument === '') {
            return new \ConfigTransformer202109036\PhpParser\Node\Scalar\String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $argumentValue = \ConfigTransformer202109036\PhpParser\BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof \ConfigTransformer202109036\PhpParser\Node\Scalar\String_) {
            $argumentValue = new \ConfigTransformer202109036\PhpParser\Node\Expr\BinaryOp\Concat(new \ConfigTransformer202109036\PhpParser\Node\Scalar\MagicConst\Dir(), $argumentValue);
        }
        return $argumentValue;
    }
    public function createClassReference(string $className) : \ConfigTransformer202109036\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : \ConfigTransformer202109036\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \ConfigTransformer202109036\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer202109036\PhpParser\Node\Name\FullyQualified($className), $constantName);
    }
    public function createFalse() : \ConfigTransformer202109036\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer202109036\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer202109036\PhpParser\Node\Name('false'));
    }
    public function createTrue() : \ConfigTransformer202109036\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer202109036\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer202109036\PhpParser\Node\Name('true'));
    }
}
