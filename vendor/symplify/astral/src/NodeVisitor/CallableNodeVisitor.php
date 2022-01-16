<?php

declare (strict_types=1);
namespace ConfigTransformer202201160\Symplify\Astral\NodeVisitor;

use ConfigTransformer202201160\PhpParser\Node;
use ConfigTransformer202201160\PhpParser\Node\Expr;
use ConfigTransformer202201160\PhpParser\Node\Stmt;
use ConfigTransformer202201160\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202201160\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer202201160\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\ConfigTransformer202201160\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer202201160\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202201160\PhpParser\Node\Expr) {
            return new \ConfigTransformer202201160\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
