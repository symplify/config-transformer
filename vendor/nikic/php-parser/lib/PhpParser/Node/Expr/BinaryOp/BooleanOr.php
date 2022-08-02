<?php

declare (strict_types=1);
namespace ConfigTransformer202208\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202208\PhpParser\Node\Expr\BinaryOp;
class BooleanOr extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '||';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BooleanOr';
    }
}
