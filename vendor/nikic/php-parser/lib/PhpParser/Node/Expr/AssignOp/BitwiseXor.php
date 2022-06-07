<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202206072\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
