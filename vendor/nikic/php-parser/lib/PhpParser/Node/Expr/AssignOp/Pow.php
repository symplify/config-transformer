<?php

declare (strict_types=1);
namespace ConfigTransformer2021100110\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021100110\PhpParser\Node\Expr\AssignOp;
class Pow extends \ConfigTransformer2021100110\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Pow';
    }
}
