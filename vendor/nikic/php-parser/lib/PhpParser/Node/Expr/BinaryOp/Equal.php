<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022011110\PhpParser\Node\Expr\BinaryOp;
class Equal extends \ConfigTransformer2022011110\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '==';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Equal';
    }
}
