<?php

declare (strict_types=1);
namespace ConfigTransformer202106194\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202106194\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends \ConfigTransformer202106194\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
