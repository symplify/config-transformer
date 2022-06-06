<?php

declare (strict_types=1);
namespace ConfigTransformer202206063\PhpParser\NodeVisitor;

use ConfigTransformer202206063\PhpParser\Node;
use ConfigTransformer202206063\PhpParser\NodeTraverser;
use ConfigTransformer202206063\PhpParser\NodeVisitorAbstract;
/**
 * This visitor can be used to find the first node satisfying some criterion determined by
 * a filter callback.
 */
class FirstFindingVisitor extends \ConfigTransformer202206063\PhpParser\NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var null|Node Found node */
    protected $foundNode;
    public function __construct(callable $filterCallback)
    {
        $this->filterCallback = $filterCallback;
    }
    /**
     * Get found node satisfying the filter callback.
     *
     * Returns null if no node satisfies the filter callback.
     *
     * @return null|Node Found node (or null if not found)
     */
    public function getFoundNode()
    {
        return $this->foundNode;
    }
    public function beforeTraverse(array $nodes)
    {
        $this->foundNode = null;
        return null;
    }
    public function enterNode(\ConfigTransformer202206063\PhpParser\Node $node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNode = $node;
            return \ConfigTransformer202206063\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        }
        return null;
    }
}
