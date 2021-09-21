<?php

declare (strict_types=1);
namespace ConfigTransformer202109216\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202109216\PhpParser\Node\Expr\AssignOp;
class ShiftRight extends \ConfigTransformer202109216\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftRight';
    }
}
