<?php

declare (strict_types=1);
namespace ConfigTransformer202206019\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202206019\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class ArrayShapeNode implements \ConfigTransformer202206019\PHPStan\PhpDocParser\Ast\Type\TypeNode
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
