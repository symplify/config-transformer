<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021081610\PhpParser\Node\Expr\AssignOp;
class Div extends \ConfigTransformer2021081610\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
