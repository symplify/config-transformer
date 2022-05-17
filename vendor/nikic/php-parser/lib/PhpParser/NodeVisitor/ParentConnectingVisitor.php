<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\PhpParser\NodeVisitor;

use function array_pop;
use function count;
use ConfigTransformer2022051710\PhpParser\Node;
use ConfigTransformer2022051710\PhpParser\NodeVisitorAbstract;
/**
 * Visitor that connects a child node to its parent node.
 *
 * On the child node, the parent node can be accessed through
 * <code>$node->getAttribute('parent')</code>.
 */
final class ParentConnectingVisitor extends \ConfigTransformer2022051710\PhpParser\NodeVisitorAbstract
{
    /**
     * @var Node[]
     */
    private $stack = [];
    public function beforeTraverse(array $nodes)
    {
        $this->stack = [];
    }
    public function enterNode(\ConfigTransformer2022051710\PhpParser\Node $node)
    {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[\count($this->stack) - 1]);
        }
        $this->stack[] = $node;
    }
    public function leaveNode(\ConfigTransformer2022051710\PhpParser\Node $node)
    {
        \array_pop($this->stack);
    }
}
