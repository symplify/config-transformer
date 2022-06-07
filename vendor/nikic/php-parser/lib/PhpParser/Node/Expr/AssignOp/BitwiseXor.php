<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022060710\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
