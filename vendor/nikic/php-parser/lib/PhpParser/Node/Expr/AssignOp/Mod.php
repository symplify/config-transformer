<?php

declare (strict_types=1);
namespace ConfigTransformer202110125\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202110125\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer202110125\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
