<?php

declare (strict_types=1);
namespace ConfigTransformer202108232\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202108232\PhpParser\Node\Expr\AssignOp;
class Coalesce extends \ConfigTransformer202108232\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
