<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202206079\PhpParser\BuilderHelpers;
use ConfigTransformer202206079\PhpParser\Node\Expr;
use ConfigTransformer202206079\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer202206079\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202206079\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202206079\PhpParser\Node\Name;
use ConfigTransformer202206079\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202206079\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202206079\PhpParser\Node\Scalar\String_;
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
            $argumentValue = new Concat(new Dir(), $argumentValue);
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
