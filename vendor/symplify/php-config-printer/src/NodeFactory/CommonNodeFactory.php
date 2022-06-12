<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer20220612\PhpParser\BuilderHelpers;
use ConfigTransformer20220612\PhpParser\Node\Expr;
use ConfigTransformer20220612\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer20220612\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer20220612\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer20220612\PhpParser\Node\Name;
use ConfigTransformer20220612\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer20220612\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer20220612\PhpParser\Node\Scalar\String_;
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
        $argumentValue = BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof String_) {
            return new Concat(new Dir(), $argumentValue);
        }
        return $argumentValue;
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
