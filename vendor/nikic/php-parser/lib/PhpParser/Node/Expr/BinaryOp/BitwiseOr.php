<?php

declare (strict_types=1);
namespace ConfigTransformer20220611\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer20220611\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '|';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseOr';
    }
}
