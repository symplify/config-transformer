<?php

declare (strict_types=1);
namespace ConfigTransformer202204161\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202204161\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class CallableTypeNode implements \ConfigTransformer202204161\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var IdentifierTypeNode */
    public $identifier;
    /** @var CallableTypeParameterNode[] */
    public $parameters;
    /** @var TypeNode */
    public $returnType;
    public function __construct(\ConfigTransformer202204161\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifier, array $parameters, \ConfigTransformer202204161\PHPStan\PhpDocParser\Ast\Type\TypeNode $returnType)
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
