<?php

declare (strict_types=1);
namespace ConfigTransformer202202249\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202202249\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer202202249\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class MethodTagValueNode implements \ConfigTransformer202202249\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var bool */
    public $isStatic;
    /** @var TypeNode|null */
    public $returnType;
    /** @var string */
    public $methodName;
    /** @var MethodTagValueParameterNode[] */
    public $parameters;
    /** @var string (may be empty) */
    public $description;
    public function __construct(bool $isStatic, ?\ConfigTransformer202202249\PHPStan\PhpDocParser\Ast\Type\TypeNode $returnType, string $methodName, array $parameters, string $description)
    {
        $this->isStatic = $isStatic;
        $this->returnType = $returnType;
        $this->methodName = $methodName;
        $this->parameters = $parameters;
        $this->description = $description;
    }
    public function __toString() : string
    {
        $static = $this->isStatic ? 'static ' : '';
        $returnType = $this->returnType !== null ? "{$this->returnType} " : '';
        $parameters = \implode(', ', $this->parameters);
        $description = $this->description !== '' ? " {$this->description}" : '';
        return "{$static}{$returnType}{$this->methodName}({$parameters}){$description}";
    }
}
