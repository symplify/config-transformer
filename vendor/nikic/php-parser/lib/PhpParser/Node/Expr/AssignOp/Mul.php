<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021120410\PhpParser\Node\Expr\AssignOp;
class Mul extends \ConfigTransformer2021120410\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mul';
    }
}
