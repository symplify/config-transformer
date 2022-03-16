<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprArrayNode implements \ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
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
