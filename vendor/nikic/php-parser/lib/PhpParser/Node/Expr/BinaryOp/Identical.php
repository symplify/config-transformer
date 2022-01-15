<?php

declare (strict_types=1);
namespace ConfigTransformer202201156\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202201156\PhpParser\Node\Expr\BinaryOp;
class Identical extends \ConfigTransformer202201156\PhpParser\Node\Expr\BinaryOp
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
