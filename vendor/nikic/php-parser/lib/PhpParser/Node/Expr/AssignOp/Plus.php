<?php

declare (strict_types=1);
namespace ConfigTransformer202107232\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202107232\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer202107232\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
