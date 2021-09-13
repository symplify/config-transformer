<?php

declare (strict_types=1);
namespace ConfigTransformer202109131\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202109131\PhpParser\Node\Expr\AssignOp;
class Pow extends \ConfigTransformer202109131\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Pow';
    }
}
