<?php

declare (strict_types=1);
namespace ConfigTransformer202110017\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202110017\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer202110017\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
