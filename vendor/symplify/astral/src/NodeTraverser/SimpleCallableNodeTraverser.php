<?php

declare (strict_types=1);
namespace ConfigTransformer202112118\Symplify\Astral\NodeTraverser;

use ConfigTransformer202112118\PhpParser\Node;
use ConfigTransformer202112118\PhpParser\NodeTraverser;
use ConfigTransformer202112118\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
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
        $nodeTraverser = new \ConfigTransformer202112118\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202112118\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
