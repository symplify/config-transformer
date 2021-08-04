<?php

declare (strict_types=1);
namespace ConfigTransformer2021080410\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021080410\PhpParser\Node\Expr\AssignOp;
class BitwiseXor extends \ConfigTransformer2021080410\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseXor';
    }
}
