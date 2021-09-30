<?php

declare (strict_types=1);
namespace ConfigTransformer2021093010\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021093010\PhpParser\Node\Expr\AssignOp;
class Concat extends \ConfigTransformer2021093010\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
