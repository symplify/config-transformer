<?php

declare (strict_types=1);
namespace ConfigTransformer202108029\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202108029\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends \ConfigTransformer202108029\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
