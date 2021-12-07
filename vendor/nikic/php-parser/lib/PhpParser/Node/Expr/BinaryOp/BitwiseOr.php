<?php

declare (strict_types=1);
namespace ConfigTransformer202112078\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202112078\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends \ConfigTransformer202112078\PhpParser\Node\Expr\BinaryOp
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
