<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Node\Expr\AssignOp;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr\AssignOp;
class Coalesce extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
