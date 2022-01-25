<?php

declare (strict_types=1);
namespace ConfigTransformer202201258\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202201258\PhpParser\Node\Expr\BinaryOp;
class Equal extends \ConfigTransformer202201258\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '==';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Equal';
    }
}
