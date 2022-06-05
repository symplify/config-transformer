<?php

declare (strict_types=1);
namespace ConfigTransformer202206056\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202206056\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer202206056\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
