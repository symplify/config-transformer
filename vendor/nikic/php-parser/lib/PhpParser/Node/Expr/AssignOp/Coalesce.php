<?php

declare (strict_types=1);
namespace ConfigTransformer20220610\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer20220610\PhpParser\Node\Expr\AssignOp;
class Coalesce extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
