<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;

final class CommonFactory
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
}
