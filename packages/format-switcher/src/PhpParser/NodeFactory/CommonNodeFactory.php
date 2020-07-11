<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;

final class CommonNodeFactory
{
    public function createAbsoluteDirExpr($argument): Expr
    {
        if (is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }

        $argumentValue = BuilderHelpers::normalizeValue($argument);

        if ($argumentValue instanceof String_) {
            $argumentValue = new Concat(new Dir(), $argumentValue);
        }

        return $argumentValue;
    }

    public function createClassReference(string $className): ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }

    public function createConstFetch(string $className, string $constantName): ClassConstFetch
    {
        return new ClassConstFetch(new FullyQualified($className), $constantName);
    }
}
