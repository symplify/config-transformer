<?php

declare (strict_types=1);
namespace ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\Node;
use ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class MethodTagValueParameterNode implements \ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\Node
{
    use NodeAttributes;
    /** @var TypeNode|null */
    public $type;
    /** @var bool */
    public $isReference;
    /** @var bool */
    public $isVariadic;
    /** @var string */
    public $parameterName;
    /** @var ConstExprNode|null */
    public $defaultValue;
    public function __construct(?\ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, bool $isReference, bool $isVariadic, string $parameterName, ?\ConfigTransformer202203169\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $defaultValue)
    {
        $this->type = $type;
        $this->isReference = $isReference;
        $this->isVariadic = $isVariadic;
        $this->parameterName = $parameterName;
        $this->defaultValue = $defaultValue;
    }
    public function __toString() : string
    {
        $type = $this->type !== null ? "{$this->type} " : '';
        $isReference = $this->isReference ? '&' : '';
        $isVariadic = $this->isVariadic ? '...' : '';
        $default = $this->defaultValue !== null ? " = {$this->defaultValue}" : '';
        return "{$type}{$isReference}{$isVariadic}{$this->parameterName}{$default}";
    }
}
