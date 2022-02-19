<?php

declare (strict_types=1);
namespace ConfigTransformer202202194\Symplify\Astral\NodeTraverser;

use ConfigTransformer202202194\PhpParser\Node;
use ConfigTransformer202202194\PhpParser\NodeTraverser;
use ConfigTransformer202202194\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
/**
 * @api
 */
final class SimpleCallableNodeTraverser
{
    /**
     * @param callable(Node $node): (int|Node|null) $callable
     * @param mixed[]|\PhpParser\Node|null $nodes
     */
    public function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        if ($nodes === null) {
            return;
        }
        if ($nodes === []) {
            return;
        }
        if (!\is_array($nodes)) {
            $nodes = [$nodes];
        }
        $nodeTraverser = new \ConfigTransformer202202194\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202202194\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
