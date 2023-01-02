<?php

declare (strict_types=1);
namespace ConfigTransformer202301\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202301\PhpParser\Node\Expr\BinaryOp;
class Identical extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '===';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Identical';
    }
}
