<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202107154\PhpParser\Node\Expr\BinaryOp;
class BitwiseXor extends \ConfigTransformer202107154\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '^';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseXor';
    }
}
