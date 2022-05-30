<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202205306\PhpParser\Node\Expr\BinaryOp;
class ShiftRight extends \ConfigTransformer202205306\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '>>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_ShiftRight';
    }
}
