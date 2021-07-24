<?php

declare (strict_types=1);
namespace ConfigTransformer202107246\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202107246\PhpParser\Node\Expr\BinaryOp;
class Concat extends \ConfigTransformer202107246\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '.';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Concat';
    }
}
