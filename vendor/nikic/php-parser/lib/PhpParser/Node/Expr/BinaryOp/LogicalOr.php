<?php

declare (strict_types=1);
namespace ConfigTransformer202112028\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202112028\PhpParser\Node\Expr\BinaryOp;
class LogicalOr extends \ConfigTransformer202112028\PhpParser\Node\Expr\BinaryOp
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
