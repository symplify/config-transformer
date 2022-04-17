<?php

declare (strict_types=1);
namespace ConfigTransformer202204172\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202204172\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprTrueNode implements \ConfigTransformer202204172\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'true';
    }
}
