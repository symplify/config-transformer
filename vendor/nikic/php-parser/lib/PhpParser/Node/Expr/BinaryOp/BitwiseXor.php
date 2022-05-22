<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022052210\PhpParser\Node\Expr\BinaryOp;
class BitwiseXor extends \ConfigTransformer2022052210\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '^';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseXor';
    }
}
