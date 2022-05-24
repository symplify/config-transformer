<?php

declare (strict_types=1);
namespace ConfigTransformer202205249\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202205249\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class UnionTypeNode implements \ConfigTransformer202205249\PHPStan\PhpDocParser\Ast\Type\TypeNode
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
        return '(' . \implode(' | ', $this->types) . ')';
    }
}
