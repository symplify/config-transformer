<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022031610\PhpParser\Node\Expr\BinaryOp;
class Identical extends \ConfigTransformer2022031610\PhpParser\Node\Expr\BinaryOp
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
