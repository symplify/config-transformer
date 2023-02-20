<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302\PhpParser\Node\Expr\AssignOp;

use ConfigTransformerPrefix202302\PhpParser\Node\Expr\AssignOp;
class Div extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
