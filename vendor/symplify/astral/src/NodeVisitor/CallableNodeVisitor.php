<?php

declare (strict_types=1);
namespace ConfigTransformer202203166\Symplify\Astral\NodeVisitor;

use ConfigTransformer202203166\PhpParser\Node;
use ConfigTransformer202203166\PhpParser\Node\Expr;
use ConfigTransformer202203166\PhpParser\Node\Stmt;
use ConfigTransformer202203166\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202203166\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer202203166\PhpParser\NodeVisitorAbstract
{
    /**
     * @var callable(Node): (int|Node|null)
     */
    private $callable;
    /**
     * @param callable(Node $node): (int|Node|null) $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }
    /**
     * @return int|\PhpParser\Node|null
     */
    public function enterNode(\ConfigTransformer202203166\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer202203166\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202203166\PhpParser\Node\Expr) {
            return new \ConfigTransformer202203166\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
