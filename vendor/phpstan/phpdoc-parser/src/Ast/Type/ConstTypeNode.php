<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstTypeNode implements \ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ConstExprNode */
    public $constExpr;
    public function __construct(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $constExpr)
    {
        $this->constExpr = $constExpr;
    }
    public function __toString() : string
    {
        return $this->constExpr->__toString();
    }
}
