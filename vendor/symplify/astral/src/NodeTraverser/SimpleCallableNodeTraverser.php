<?php

declare (strict_types=1);
namespace ConfigTransformer202111274\Symplify\Astral\NodeTraverser;

use ConfigTransformer202111274\PhpParser\Node;
use ConfigTransformer202111274\PhpParser\NodeTraverser;
use ConfigTransformer202111274\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
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
        $nodeTraverser = new \ConfigTransformer202111274\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202111274\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
