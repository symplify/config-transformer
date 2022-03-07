<?php

declare (strict_types=1);
namespace ConfigTransformer202203078\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202203078\PhpParser\Node\Expr\BinaryOp;
class BitwiseAnd extends \ConfigTransformer202203078\PhpParser\Node\Expr\BinaryOp
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
