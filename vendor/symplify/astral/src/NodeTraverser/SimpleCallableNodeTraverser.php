<?php

declare (strict_types=1);
namespace ConfigTransformer202201151\Symplify\Astral\NodeTraverser;

use ConfigTransformer202201151\PhpParser\Node;
use ConfigTransformer202201151\PhpParser\NodeTraverser;
use ConfigTransformer202201151\Symplify\Astral\NodeVisitor\CallableNodeVisitor;
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
        $nodeTraverser = new \ConfigTransformer202201151\PhpParser\NodeTraverser();
        $callableNodeVisitor = new \ConfigTransformer202201151\Symplify\Astral\NodeVisitor\CallableNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
