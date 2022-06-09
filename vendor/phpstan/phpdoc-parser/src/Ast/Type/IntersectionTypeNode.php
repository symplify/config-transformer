<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer20220609\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class IntersectionTypeNode implements TypeNode
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
        return '(' . implode(' & ', $this->types) . ')';
    }
}
