<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends \ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp
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
