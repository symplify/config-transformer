<?php

declare (strict_types=1);
namespace ConfigTransformer202109294\Symplify\Astral\NodeTraverser;

use ConfigTransformer202109294\PhpParser\Node;
use ConfigTransformer202109294\PhpParser\NodeTraverser;
use ConfigTransformer202109294\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
final class SimpleCallableNodeTraverser
{
    /**
     * @param Node|Node[]|null $nodes
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
        $nodeTraverser = new \ConfigTransformer202109294\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202109294\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
