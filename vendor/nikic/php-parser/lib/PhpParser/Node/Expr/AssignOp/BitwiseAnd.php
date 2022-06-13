<?php

declare (strict_types=1);
namespace ConfigTransformer20220613\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer20220613\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
