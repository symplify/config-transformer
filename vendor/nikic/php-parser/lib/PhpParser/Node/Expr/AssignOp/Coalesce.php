<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022031610\PhpParser\Node\Expr\AssignOp;
class Coalesce extends \ConfigTransformer2022031610\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
