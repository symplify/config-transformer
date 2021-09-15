<?php

declare (strict_types=1);
namespace ConfigTransformer202109151\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202109151\PhpParser\Node\Expr\BinaryOp;
class GreaterOrEqual extends \ConfigTransformer202109151\PhpParser\Node\Expr\BinaryOp
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
