<?php

declare (strict_types=1);
namespace ConfigTransformer202206011\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202206011\PhpParser\Node\Expr\AssignOp;
class ShiftLeft extends \ConfigTransformer202206011\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftLeft';
    }
}
