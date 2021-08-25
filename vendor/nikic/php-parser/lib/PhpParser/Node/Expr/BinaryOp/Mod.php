<?php

declare (strict_types=1);
namespace ConfigTransformer2021082510\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2021082510\PhpParser\Node\Expr\BinaryOp;
class Mod extends \ConfigTransformer2021082510\PhpParser\Node\Expr\BinaryOp
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
