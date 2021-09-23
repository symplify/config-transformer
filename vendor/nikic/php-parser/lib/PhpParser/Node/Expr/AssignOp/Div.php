<?php

declare (strict_types=1);
namespace ConfigTransformer202109236\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202109236\PhpParser\Node\Expr\AssignOp;
class Div extends \ConfigTransformer202109236\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
