<?php

declare (strict_types=1);
namespace ConfigTransformer202207\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202207\PhpParser\Node\Expr\AssignOp;
class Concat extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
