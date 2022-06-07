<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022060710\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'xor';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalXor';
    }
}
