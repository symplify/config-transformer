<?php

declare (strict_types=1);
namespace ConfigTransformer202106287\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202106287\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends \ConfigTransformer202106287\PhpParser\Node\Expr\BinaryOp
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
