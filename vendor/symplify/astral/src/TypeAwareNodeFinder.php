<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral;

use ConfigTransformer202208\PhpParser\Node;
use ConfigTransformer202208\PhpParser\NodeFinder;
/**
 * @api
 */
final class TypeAwareNodeFinder
{
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @template TNode as Node
     *
     * @param mixed[]|\PhpParser\Node $nodes
     * @param class-string<TNode> $type
     * @return TNode|null
     */
    public function findFirstInstanceOf($nodes, string $type) : ?Node
    {
        return $this->nodeFinder->findFirstInstanceOf($nodes, $type);
    }
    /**
     * @template TNode as Node
     *
     * @param mixed[]|\PhpParser\Node $nodes
     * @param class-string<TNode> $type
     * @return TNode[]
     */
    public function findInstanceOf($nodes, string $type) : array
    {
        return $this->nodeFinder->findInstanceOf($nodes, $type);
    }
}
