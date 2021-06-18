<?php

declare (strict_types=1);
namespace ConfigTransformer202106181\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202106181\PhpParser\Node\Expr\BinaryOp;
class GreaterOrEqual extends \ConfigTransformer202106181\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '>=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_GreaterOrEqual';
    }
}
