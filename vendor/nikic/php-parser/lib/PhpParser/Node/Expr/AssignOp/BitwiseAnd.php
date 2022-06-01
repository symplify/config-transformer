<?php

declare (strict_types=1);
namespace ConfigTransformer202206012\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202206012\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends \ConfigTransformer202206012\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
