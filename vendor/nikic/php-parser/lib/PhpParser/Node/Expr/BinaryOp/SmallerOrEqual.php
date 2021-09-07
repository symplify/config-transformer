<?php

declare (strict_types=1);
namespace ConfigTransformer202109079\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202109079\PhpParser\Node\Expr\BinaryOp;
class SmallerOrEqual extends \ConfigTransformer202109079\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_SmallerOrEqual';
    }
}
