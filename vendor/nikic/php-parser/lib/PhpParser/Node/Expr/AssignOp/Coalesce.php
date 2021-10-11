<?php

declare (strict_types=1);
namespace ConfigTransformer202110112\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202110112\PhpParser\Node\Expr\AssignOp;
class Coalesce extends \ConfigTransformer202110112\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Coalesce';
    }
}
