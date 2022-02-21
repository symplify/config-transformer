<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer2022022110\PHPStan\PhpDocParser\Ast\NodeAttributes;
class IntersectionTypeNode implements \ConfigTransformer2022022110\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode[] */
    public $types;
    public function __construct(array $types)
    {
        $this->types = $types;
    }
    public function __toString() : string
    {
        return '(' . \implode(' & ', $this->types) . ')';
    }
}
