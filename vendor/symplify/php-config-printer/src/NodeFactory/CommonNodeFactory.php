<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformerPrefix202310\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202310\PhpParser\Node\Expr;
use ConfigTransformerPrefix202310\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformerPrefix202310\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformerPrefix202310\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformerPrefix202310\PhpParser\Node\Name;
use ConfigTransformerPrefix202310\PhpParser\Node\Name\FullyQualified;
use ConfigTransformerPrefix202310\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformerPrefix202310\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    /**
     * @param mixed $argument
     */
    public function createAbsoluteDirExpr($argument) : Expr
    {
        if ($argument === '') {
            return new String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $expr = BuilderHelpers::normalizeValue($argument);
        if ($expr instanceof String_) {
            return new Concat(new Dir(), $expr);
        }
        return $expr;
    }
    public function createClassReference(string $className) : ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : ClassConstFetch
    {
        return new ClassConstFetch(new FullyQualified($className), $constantName);
    }
    public function createFalse() : ConstFetch
    {
        return new ConstFetch(new Name('false'));
    }
    public function createTrue() : ConstFetch
    {
        return new ConstFetch(new Name('true'));
    }
}
