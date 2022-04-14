<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022041410\PhpParser\Node\Expr\BinaryOp;
class ShiftLeft extends \ConfigTransformer2022041410\PhpParser\Node\Expr\BinaryOp
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
