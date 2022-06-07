<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202206079\PhpParser\Node\Expr\AssignOp;
class Pow extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Pow';
    }
}
