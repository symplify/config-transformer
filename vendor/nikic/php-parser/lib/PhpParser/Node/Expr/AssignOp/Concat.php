<?php

declare (strict_types=1);
namespace ConfigTransformer202108305\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202108305\PhpParser\Node\Expr\AssignOp;
class Concat extends \ConfigTransformer202108305\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
