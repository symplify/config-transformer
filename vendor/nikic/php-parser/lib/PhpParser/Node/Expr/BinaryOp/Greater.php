<?php

declare (strict_types=1);
namespace ConfigTransformer202110016\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202110016\PhpParser\Node\Expr\BinaryOp;
class Greater extends \ConfigTransformer202110016\PhpParser\Node\Expr\BinaryOp
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
