<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202206079\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstTypeNode implements \ConfigTransformer202206079\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ConstExprNode */
    public $constExpr;
    public function __construct(\ConfigTransformer202206079\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $constExpr)
    {
        $this->constExpr = $constExpr;
    }
    public function __toString() : string
    {
        return $this->constExpr->__toString();
    }
}
