<?php

declare (strict_types=1);
namespace ConfigTransformer202205215\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202205215\PhpParser\Node\Expr\BinaryOp;
class Mod extends \ConfigTransformer202205215\PhpParser\Node\Expr\BinaryOp
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
