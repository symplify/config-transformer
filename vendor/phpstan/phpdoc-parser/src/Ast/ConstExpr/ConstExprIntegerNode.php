<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprIntegerNode implements \ConfigTransformer2022022410\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    /** @var string */
    public $value;
    public function __construct(string $value)
    {
        $this->value = $value;
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
