<?php

declare (strict_types=1);
namespace ConfigTransformer202202245\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202202245\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprIntegerNode implements \ConfigTransformer202202245\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
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