<?php

declare (strict_types=1);
namespace ConfigTransformer2021070710\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021070710\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer2021070710\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
