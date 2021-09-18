<?php

declare (strict_types=1);
namespace ConfigTransformer2021091810\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021091810\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer2021091810\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
