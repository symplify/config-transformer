<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2021072110\PhpParser\Node\Expr\BinaryOp;
class Pow extends \ConfigTransformer2021072110\PhpParser\Node\Expr\BinaryOp
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
