<?php

declare (strict_types=1);
namespace ConfigTransformer202201303\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202201303\PhpParser\Node\Expr\BinaryOp;
class Mul extends \ConfigTransformer202201303\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '*';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Mul';
    }
}
