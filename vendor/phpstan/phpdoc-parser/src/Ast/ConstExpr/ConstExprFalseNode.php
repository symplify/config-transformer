<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer2022060710\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprFalseNode implements ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'false';
    }
}
