<?php

declare (strict_types=1);
namespace ConfigTransformer202111113\Symplify\Astral\NodeTraverser;

use ConfigTransformer202111113\PhpParser\Node;
use ConfigTransformer202111113\PhpParser\NodeTraverser;
use ConfigTransformer202111113\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
/**
 * @api
 */
final class SimpleCallableNodeTraverser
{
    /**
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
        $nodeTraverser = new \ConfigTransformer202111113\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202111113\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
