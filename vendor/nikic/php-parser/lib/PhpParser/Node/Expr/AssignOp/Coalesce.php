<?php

declare (strict_types=1);
namespace ConfigTransformer202201248\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202201248\PhpParser\Node\Expr\AssignOp;
class Coalesce extends \ConfigTransformer202201248\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
