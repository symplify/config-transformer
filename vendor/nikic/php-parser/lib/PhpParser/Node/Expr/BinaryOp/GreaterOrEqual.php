<?php

declare (strict_types=1);
namespace ConfigTransformer202209\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202209\PhpParser\Node\Expr\BinaryOp;
class GreaterOrEqual extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '>=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_GreaterOrEqual';
    }
}
