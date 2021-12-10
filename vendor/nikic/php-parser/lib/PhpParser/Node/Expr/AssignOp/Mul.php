<?php

declare (strict_types=1);
namespace ConfigTransformer202112108\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202112108\PhpParser\Node\Expr\AssignOp;
class Mul extends \ConfigTransformer202112108\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mul';
    }
}
