<?php

declare (strict_types=1);
namespace ConfigTransformer202205124\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202205124\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class ConstExprArrayNode implements \ConfigTransformer202205124\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    /** @var ConstExprArrayItemNode[] */
    public $items;
    /**
     * @param ConstExprArrayItemNode[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
    public function __toString() : string
    {
        return '[' . \implode(', ', $this->items) . ']';
    }
}
