<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\Astral\NodeVisitor;

use ConfigTransformer2022031610\PhpParser\Node;
use ConfigTransformer2022031610\PhpParser\Node\Expr;
use ConfigTransformer2022031610\PhpParser\Node\Stmt;
use ConfigTransformer2022031610\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022031610\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer2022031610\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\ConfigTransformer2022031610\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer2022031610\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer2022031610\PhpParser\Node\Expr) {
            return new \ConfigTransformer2022031610\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
