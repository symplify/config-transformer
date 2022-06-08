<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class UnionTypeNode implements TypeNode
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
        return '(' . implode(' | ', $this->types) . ')';
    }
}
