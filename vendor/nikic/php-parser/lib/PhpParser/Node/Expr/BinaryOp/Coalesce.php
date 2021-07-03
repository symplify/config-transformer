<?php

declare (strict_types=1);
namespace ConfigTransformer202107032\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202107032\PhpParser\Node\Expr\BinaryOp;
class Coalesce extends \ConfigTransformer202107032\PhpParser\Node\Expr\BinaryOp
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
