<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202401\PhpParser\Node\Expr\AssignOp;

use ConfigTransformerPrefix202401\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
