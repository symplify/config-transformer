<?php

declare (strict_types=1);
namespace ConfigTransformer202111029\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202111029\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer202111029\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
