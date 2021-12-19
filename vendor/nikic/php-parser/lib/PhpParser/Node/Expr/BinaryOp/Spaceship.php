<?php

declare (strict_types=1);
namespace ConfigTransformer202112195\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202112195\PhpParser\Node\Expr\BinaryOp;
class Spaceship extends \ConfigTransformer202112195\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Spaceship';
    }
}
