<?php

declare (strict_types=1);
namespace ConfigTransformer202106185\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202106185\PhpParser\Node\Expr\BinaryOp;
class BitwiseAnd extends \ConfigTransformer202106185\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '&';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseAnd';
    }
}
