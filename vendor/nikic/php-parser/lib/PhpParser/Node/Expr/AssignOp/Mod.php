<?php

declare (strict_types=1);
namespace ConfigTransformer202108306\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202108306\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer202108306\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
