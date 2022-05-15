<?php

declare (strict_types=1);
namespace ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstFetchNode implements \ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    /** @var string class name for class constants or empty string for non-class constants */
    public $className;
    /** @var string */
    public $name;
    public function __construct(string $className, string $name)
    {
        $this->className = $className;
        $this->name = $name;
    }
    public function __toString() : string
    {
        if ($this->className === '') {
            return $this->name;
        }
        return "{$this->className}::{$this->name}";
    }
}
