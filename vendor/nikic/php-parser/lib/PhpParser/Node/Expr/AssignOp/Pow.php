<?php

declare (strict_types=1);
namespace ConfigTransformer202112315\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202112315\PhpParser\Node\Expr\AssignOp;
class Pow extends \ConfigTransformer202112315\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Pow';
    }
}
