<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\NodeVisitor;

use ConfigTransformerPrefix202507\PhpParser\Node;
use ConfigTransformerPrefix202507\PhpParser\NodeVisitorAbstract;
/**
 * This visitor can be used to find and collect all nodes satisfying some criterion determined by
 * a filter callback.
 */
class FindingVisitor extends NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var list<Node> Found nodes */
    protected $foundNodes;
    public function __construct(callable $filterCallback)
    {
        $this->filterCallback = $filterCallback;
    }
    /**
     * Get found nodes satisfying the filter callback.
     *
     * Nodes are returned in pre-order.
     *
     * @return list<Node> Found nodes
     */
    public function getFoundNodes() : array
    {
        return $this->foundNodes;
    }
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->foundNodes = [];
        return null;
    }
    public function enterNode(Node $node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNodes[] = $node;
        }
        return null;
    }
}
