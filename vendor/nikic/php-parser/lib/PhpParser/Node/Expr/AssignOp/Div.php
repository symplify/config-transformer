<?php

declare (strict_types=1);
namespace ConfigTransformer202110029\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202110029\PhpParser\Node\Expr\AssignOp;
class Div extends \ConfigTransformer202110029\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
