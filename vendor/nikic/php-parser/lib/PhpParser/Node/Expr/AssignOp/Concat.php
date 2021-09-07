<?php

declare (strict_types=1);
namespace ConfigTransformer202109075\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202109075\PhpParser\Node\Expr\AssignOp;
class Concat extends \ConfigTransformer202109075\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Concat';
    }
}
