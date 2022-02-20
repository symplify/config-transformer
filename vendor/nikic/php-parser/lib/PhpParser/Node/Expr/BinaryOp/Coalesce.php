<?php

declare (strict_types=1);
namespace ConfigTransformer202202206\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202202206\PhpParser\Node\Expr\BinaryOp;
class Coalesce extends \ConfigTransformer202202206\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '??';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Coalesce';
    }
}
