<?php

declare (strict_types=1);
namespace ConfigTransformer202203054\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202203054\PhpParser\Node\Expr\BinaryOp;
class ShiftLeft extends \ConfigTransformer202203054\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<<';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_ShiftLeft';
    }
}
