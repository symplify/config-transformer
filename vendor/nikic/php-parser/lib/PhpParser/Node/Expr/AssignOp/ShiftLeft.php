<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022011110\PhpParser\Node\Expr\AssignOp;
class ShiftLeft extends \ConfigTransformer2022011110\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftLeft';
    }
}
