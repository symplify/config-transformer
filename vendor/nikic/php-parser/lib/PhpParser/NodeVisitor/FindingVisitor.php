<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\PhpParser\NodeVisitor;

use ConfigTransformer202107130\PhpParser\Node;
use ConfigTransformer202107130\PhpParser\NodeVisitorAbstract;
/**
 * This visitor can be used to find and collect all nodes satisfying some criterion determined by
 * a filter callback.
 */
class FindingVisitor extends \ConfigTransformer202107130\PhpParser\NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var Node[] Found nodes */
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
     * @return Node[] Found nodes
     */
    public function getFoundNodes() : array
    {
        return $this->foundNodes;
    }
    /**
     * @param mixed[] $nodes
     */
    public function beforeTraverse($nodes)
    {
        $this->foundNodes = [];
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function enterNode($node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNodes[] = $node;
        }
        return null;
    }
}
