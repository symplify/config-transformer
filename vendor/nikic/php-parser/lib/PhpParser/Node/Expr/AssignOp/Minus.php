<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202205308\PhpParser\Node\Expr\AssignOp;
class Minus extends \ConfigTransformer202205308\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Minus';
    }
}
