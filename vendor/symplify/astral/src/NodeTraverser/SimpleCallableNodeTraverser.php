<?php

declare (strict_types=1);
namespace ConfigTransformer202108042\Symplify\Astral\NodeTraverser;

use ConfigTransformer202108042\PhpParser\Node;
use ConfigTransformer202108042\PhpParser\Node\Expr;
use ConfigTransformer202108042\PhpParser\Node\Stmt;
use ConfigTransformer202108042\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202108042\PhpParser\NodeTraverser;
use ConfigTransformer202108042\PhpParser\NodeVisitor;
use ConfigTransformer202108042\PhpParser\NodeVisitorAbstract;
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
        $nodeTraverser = new \ConfigTransformer202108042\PhpParser\NodeTraverser();
        $callableNodeVisitor = $this->createNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    private function createNodeVisitor(callable $callable) : \ConfigTransformer202108042\PhpParser\NodeVisitor
    {
        return new class($callable) extends \ConfigTransformer202108042\PhpParser\NodeVisitorAbstract
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
            public function enterNode(\ConfigTransformer202108042\PhpParser\Node $node)
            {
                $originalNode = $node;
                $callable = $this->callable;
                /** @var int|Node|null $newNode */
                $newNode = $callable($node);
                if ($originalNode instanceof \ConfigTransformer202108042\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202108042\PhpParser\Node\Expr) {
                    return new \ConfigTransformer202108042\PhpParser\Node\Stmt\Expression($newNode);
                }
                return $newNode;
            }
        };
    }
}
