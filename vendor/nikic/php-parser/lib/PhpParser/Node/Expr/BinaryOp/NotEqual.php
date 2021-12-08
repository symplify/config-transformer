<?php

declare (strict_types=1);
namespace ConfigTransformer202112088\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202112088\PhpParser\Node\Expr\BinaryOp;
class NotEqual extends \ConfigTransformer202112088\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotEqual';
    }
}
