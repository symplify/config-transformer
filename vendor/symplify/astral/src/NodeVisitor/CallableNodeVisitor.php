<?php

declare (strict_types=1);
namespace ConfigTransformer202110146\Symplify\Astral\NodeVisitor;

use ConfigTransformer202110146\PhpParser\Node;
use ConfigTransformer202110146\PhpParser\Node\Expr;
use ConfigTransformer202110146\PhpParser\Node\Stmt;
use ConfigTransformer202110146\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202110146\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer202110146\PhpParser\NodeVisitorAbstract
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
     * @param \PhpParser\Node $node
     */
    public function enterNode($node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer202110146\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202110146\PhpParser\Node\Expr) {
            return new \ConfigTransformer202110146\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
