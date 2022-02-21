<?php

declare (strict_types=1);
namespace ConfigTransformer202202219\Symplify\Astral\NodeTraverser;

use ConfigTransformer202202219\PhpParser\Node;
use ConfigTransformer202202219\PhpParser\NodeTraverser;
use ConfigTransformer202202219\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
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
        $nodeTraverser = new \ConfigTransformer202202219\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202202219\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
