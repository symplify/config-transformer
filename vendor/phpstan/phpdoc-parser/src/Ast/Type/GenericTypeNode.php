<?php

declare (strict_types=1);
namespace ConfigTransformer202203164\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202203164\PHPStan\PhpDocParser\Ast\NodeAttributes;
class GenericTypeNode implements \ConfigTransformer202203164\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var IdentifierTypeNode */
    public $type;
    /** @var TypeNode[] */
    public $genericTypes;
    public function __construct(\ConfigTransformer202203164\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $type, array $genericTypes)
    {
        $this->type = $type;
        $this->genericTypes = $genericTypes;
    }
    public function __toString() : string
    {
        return $this->type . '<' . \implode(', ', $this->genericTypes) . '>';
    }
}
