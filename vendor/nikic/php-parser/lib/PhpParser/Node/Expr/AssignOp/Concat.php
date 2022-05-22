<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022052210\PhpParser\Node\Expr\AssignOp;
class Concat extends \ConfigTransformer2022052210\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
