<?php

declare (strict_types=1);
namespace ConfigTransformer202107034\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202107034\PhpParser\Node\Expr\BinaryOp;
class Spaceship extends \ConfigTransformer202107034\PhpParser\Node\Expr\BinaryOp
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
