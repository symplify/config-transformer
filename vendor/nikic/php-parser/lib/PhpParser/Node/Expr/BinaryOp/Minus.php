<?php

declare (strict_types=1);
namespace ConfigTransformer202201257\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202201257\PhpParser\Node\Expr\BinaryOp;
class Minus extends \ConfigTransformer202201257\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '-';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Minus';
    }
}
