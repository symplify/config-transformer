<?php

declare (strict_types=1);
namespace ConfigTransformer202202247\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202202247\PhpParser\Node\Expr\AssignOp;
class Concat extends \ConfigTransformer202202247\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
