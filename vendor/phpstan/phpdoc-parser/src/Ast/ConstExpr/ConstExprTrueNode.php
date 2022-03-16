<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprTrueNode implements \ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'true';
    }
}
