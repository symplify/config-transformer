<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer20220609\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class ArrayShapeNode implements TypeNode
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
        return 'array{' . implode(', ', $this->items) . '}';
    }
}
