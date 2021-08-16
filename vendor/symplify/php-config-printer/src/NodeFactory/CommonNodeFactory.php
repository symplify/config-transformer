<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2021081610\PhpParser\BuilderHelpers;
use ConfigTransformer2021081610\PhpParser\Node\Expr;
use ConfigTransformer2021081610\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer2021081610\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer2021081610\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021081610\PhpParser\Node\Name;
use ConfigTransformer2021081610\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021081610\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer2021081610\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    public function createAbsoluteDirExpr($argument) : \ConfigTransformer2021081610\PhpParser\Node\Expr
    {
        if ($argument === '') {
            return new \ConfigTransformer2021081610\PhpParser\Node\Scalar\String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $argumentValue = \ConfigTransformer2021081610\PhpParser\BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof \ConfigTransformer2021081610\PhpParser\Node\Scalar\String_) {
            $argumentValue = new \ConfigTransformer2021081610\PhpParser\Node\Expr\BinaryOp\Concat(new \ConfigTransformer2021081610\PhpParser\Node\Scalar\MagicConst\Dir(), $argumentValue);
        }
        return $argumentValue;
    }
    public function createClassReference(string $className) : \ConfigTransformer2021081610\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : \ConfigTransformer2021081610\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \ConfigTransformer2021081610\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer2021081610\PhpParser\Node\Name\FullyQualified($className), $constantName);
    }
    public function createFalse() : \ConfigTransformer2021081610\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer2021081610\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer2021081610\PhpParser\Node\Name('false'));
    }
    public function createTrue() : \ConfigTransformer2021081610\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer2021081610\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer2021081610\PhpParser\Node\Name('true'));
    }
}
