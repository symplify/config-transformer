<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFinder;

use ConfigTransformerPrefix202507\PhpParser\Node;
use ConfigTransformerPrefix202507\PhpParser\NodeFinder;
/**
 * @api
 * @todo remove after https://github.com/nikic/PHP-Parser/pull/869 is released
 */
final class TypeAwareNodeFinder
{
    /**
     * @readonly
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
     * @param Node[]|Node $nodes
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
     * @param Node[]|Node $nodes
     * @param class-string<TNode> $type
     * @return TNode[]
     */
    public function findInstanceOf($nodes, string $type) : array
    {
        return $this->nodeFinder->findInstanceOf($nodes, $type);
    }
}
