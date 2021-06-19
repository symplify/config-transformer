<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2021061910\PhpParser\Node\Expr\BinaryOp;
class LogicalAnd extends \ConfigTransformer2021061910\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'and';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalAnd';
    }
}
