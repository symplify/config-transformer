<?php

declare (strict_types=1);
namespace ConfigTransformer202206056\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202206056\PhpParser\Node\Expr\BinaryOp;
class Div extends \ConfigTransformer202206056\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '/';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Div';
    }
}
