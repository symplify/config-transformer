<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202312\PhpParser\Node\Expr\AssignOp;

use ConfigTransformerPrefix202312\PhpParser\Node\Expr\AssignOp;
class BitwiseOr extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseOr';
    }
}
