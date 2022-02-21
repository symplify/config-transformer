<?php

declare (strict_types=1);
namespace ConfigTransformer202202210\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202202210\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayShapeNode implements \ConfigTransformer202202210\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ArrayShapeItemNode[] */
    public $items;
    public function __construct(array $items)
    {
        $this->items = $items;
    }
    public function __toString() : string
    {
        return 'array{' . \implode(', ', $this->items) . '}';
    }
}
