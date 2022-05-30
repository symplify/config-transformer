<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp;
class NotIdentical extends \ConfigTransformer202205308\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!==';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotIdentical';
    }
}
