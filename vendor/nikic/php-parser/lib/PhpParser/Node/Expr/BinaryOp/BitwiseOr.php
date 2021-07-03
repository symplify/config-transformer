<?php

declare (strict_types=1);
namespace ConfigTransformer202107039\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202107039\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends \ConfigTransformer202107039\PhpParser\Node\Expr\BinaryOp
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
