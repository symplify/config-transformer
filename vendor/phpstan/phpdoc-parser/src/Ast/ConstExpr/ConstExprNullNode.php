<?php

declare (strict_types=1);
namespace ConfigTransformer202206056\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202206056\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprNullNode implements \ConfigTransformer202206056\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'null';
    }
}
