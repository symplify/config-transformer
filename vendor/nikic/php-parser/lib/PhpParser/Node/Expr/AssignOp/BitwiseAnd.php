<?php

declare (strict_types=1);
namespace ConfigTransformer202107116\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202107116\PhpParser\Node\Expr\AssignOp;
class BitwiseAnd extends \ConfigTransformer202107116\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseAnd';
    }
}
