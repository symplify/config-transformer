<?php

declare (strict_types=1);
namespace ConfigTransformer202108185\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202108185\PhpParser\Node\Expr\BinaryOp;
class Greater extends \ConfigTransformer202108185\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Greater';
    }
}
