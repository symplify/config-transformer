<?php

declare (strict_types=1);
namespace ConfigTransformer202107076\Symplify\Astral\NodeTraverser;

use ConfigTransformer202107076\PhpParser\Node;
use ConfigTransformer202107076\PhpParser\Node\Expr;
use ConfigTransformer202107076\PhpParser\Node\Stmt;
use ConfigTransformer202107076\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107076\PhpParser\NodeTraverser;
use ConfigTransformer202107076\PhpParser\NodeVisitor;
use ConfigTransformer202107076\PhpParser\NodeVisitorAbstract;
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
        $nodeTraverser = new \ConfigTransformer202107076\PhpParser\NodeTraverser();
        $callableNodeVisitor = $this->createNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    private function createNodeVisitor(callable $callable) : \ConfigTransformer202107076\PhpParser\NodeVisitor
    {
        return new class($callable) extends \ConfigTransformer202107076\PhpParser\NodeVisitorAbstract
        {
            /**
             * @var callable
             */
            private $callable;
            public function __construct(callable $callable)
            {
                $this->callable = $callable;
            }
            /**
             * @return int|Node|null
             */
            public function enterNode(\ConfigTransformer202107076\PhpParser\Node $node)
            {
                $originalNode = $node;
                $callable = $this->callable;
                /** @var int|Node|null $newNode */
                $newNode = $callable($node);
                if ($originalNode instanceof \ConfigTransformer202107076\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202107076\PhpParser\Node\Expr) {
                    return new \ConfigTransformer202107076\PhpParser\Node\Stmt\Expression($newNode);
                }
                return $newNode;
            }
        };
    }
}
