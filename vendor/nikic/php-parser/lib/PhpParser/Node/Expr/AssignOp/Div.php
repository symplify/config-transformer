<?php

declare (strict_types=1);
namespace ConfigTransformer202108112\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202108112\PhpParser\Node\Expr\AssignOp;
class Div extends \ConfigTransformer202108112\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Div';
    }
}
