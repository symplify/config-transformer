<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021062210\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer2021062210\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
