<?php

declare (strict_types=1);
namespace ConfigTransformer2021082910\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2021082910\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer2021082910\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
