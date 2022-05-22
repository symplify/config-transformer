<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer2022052210\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprNullNode implements \ConfigTransformer2022052210\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'null';
    }
}
