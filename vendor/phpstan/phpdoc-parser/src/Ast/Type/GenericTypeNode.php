<?php

declare (strict_types=1);
namespace ConfigTransformer202205135\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202205135\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class GenericTypeNode implements \ConfigTransformer202205135\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var IdentifierTypeNode */
    public $type;
    /** @var TypeNode[] */
    public $genericTypes;
    public function __construct(\ConfigTransformer202205135\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $type, array $genericTypes)
    {
        $this->type = $type;
        $this->genericTypes = $genericTypes;
    }
    public function __toString() : string
    {
        return $this->type . '<' . \implode(', ', $this->genericTypes) . '>';
    }
}
