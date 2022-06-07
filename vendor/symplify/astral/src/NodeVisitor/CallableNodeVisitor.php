<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\NodeVisitor;

use ConfigTransformer2022060710\PhpParser\Node;
use ConfigTransformer2022060710\PhpParser\Node\Expr;
use ConfigTransformer2022060710\PhpParser\Node\Stmt;
use ConfigTransformer2022060710\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022060710\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends NodeVisitorAbstract
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
    public function enterNode(Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof Stmt && $newNode instanceof Expr) {
            return new Expression($newNode);
        }
        return $newNode;
    }
}
