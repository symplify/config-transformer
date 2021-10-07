<?php

declare (strict_types=1);
namespace ConfigTransformer202110072\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202110072\PhpParser\Node\Expr\BinaryOp;
class Spaceship extends \ConfigTransformer202110072\PhpParser\Node\Expr\BinaryOp
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
