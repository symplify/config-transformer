<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022051710\PhpParser\Node\Expr\AssignOp;
class Plus extends \ConfigTransformer2022051710\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Plus';
    }
}
