<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202204166\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer202204166\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
