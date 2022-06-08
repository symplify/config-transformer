<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprIntegerNode implements ConstExprNode
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
