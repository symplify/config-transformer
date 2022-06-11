<?php

declare (strict_types=1);
namespace ConfigTransformer20220611\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer20220611\PhpParser\Node\Expr\AssignOp;
class ShiftRight extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftRight';
    }
}
