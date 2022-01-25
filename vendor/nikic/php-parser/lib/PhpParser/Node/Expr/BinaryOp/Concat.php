<?php

declare (strict_types=1);
namespace ConfigTransformer2022012510\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2022012510\PhpParser\Node\Expr\BinaryOp;
class Concat extends \ConfigTransformer2022012510\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '.';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Concat';
    }
}
