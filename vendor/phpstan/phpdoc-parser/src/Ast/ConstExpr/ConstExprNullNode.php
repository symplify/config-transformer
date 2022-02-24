<?php

declare (strict_types=1);
namespace ConfigTransformer202202242\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202202242\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprNullNode implements \ConfigTransformer202202242\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'null';
    }
}
