<?php

declare (strict_types=1);
namespace ConfigTransformer202111013\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202111013\PhpParser\Node\Expr\AssignOp;
class ShiftLeft extends \ConfigTransformer202111013\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_ShiftLeft';
    }
}
