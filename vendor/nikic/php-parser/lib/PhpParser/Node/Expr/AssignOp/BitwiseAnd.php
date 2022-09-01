<?php

declare (strict_types=1);
namespace ConfigTransformer202209\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202209\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
