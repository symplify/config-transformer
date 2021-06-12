<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021061210\PhpParser\Node\Expr\AssignOp;
class Coalesce extends \ConfigTransformer2021061210\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
