<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202206077\PhpParser\Node\Expr\BinaryOp;
class Pow extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '**';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Pow';
    }
}
