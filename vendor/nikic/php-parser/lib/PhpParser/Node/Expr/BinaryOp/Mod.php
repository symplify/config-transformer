<?php

declare (strict_types=1);
namespace ConfigTransformer202109227\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202109227\PhpParser\Node\Expr\BinaryOp;
class Mod extends \ConfigTransformer202109227\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '%';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Mod';
    }
}
