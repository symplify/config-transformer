<?php

declare (strict_types=1);
namespace ConfigTransformer202202022\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202202022\PhpParser\Node\Expr\BinaryOp;
class LogicalOr extends \ConfigTransformer202202022\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'or';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalOr';
    }
}
