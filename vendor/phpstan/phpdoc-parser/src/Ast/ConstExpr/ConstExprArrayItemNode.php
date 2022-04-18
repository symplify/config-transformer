<?php

declare (strict_types=1);
namespace ConfigTransformer202204182\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202204182\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprArrayItemNode implements \ConfigTransformer202204182\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    /** @var ConstExprNode|null */
    public $key;
    /** @var ConstExprNode */
    public $value;
    public function __construct(?\ConfigTransformer202204182\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $key, \ConfigTransformer202204182\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
    public function __toString() : string
    {
        if ($this->key !== null) {
            return "{$this->key} => {$this->value}";
        }
        return "{$this->value}";
    }
}
