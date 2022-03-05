<?php

declare (strict_types=1);
namespace ConfigTransformer202203054\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202203054\PHPStan\PhpDocParser\Ast\NodeAttributes;
class CallableTypeNode implements \ConfigTransformer202203054\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var IdentifierTypeNode */
    public $identifier;
    /** @var CallableTypeParameterNode[] */
    public $parameters;
    /** @var TypeNode */
    public $returnType;
    public function __construct(\ConfigTransformer202203054\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifier, array $parameters, \ConfigTransformer202203054\PHPStan\PhpDocParser\Ast\Type\TypeNode $returnType)
    {
        $this->identifier = $identifier;
        $this->parameters = $parameters;
        $this->returnType = $returnType;
    }
    public function __toString() : string
    {
        $parameters = \implode(', ', $this->parameters);
        return "{$this->identifier}({$parameters}): {$this->returnType}";
    }
}
