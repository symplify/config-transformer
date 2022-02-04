<?php

declare (strict_types=1);
namespace ConfigTransformer202202043\Symplify\Astral\NodeVisitor;

use ConfigTransformer202202043\PhpParser\Node;
use ConfigTransformer202202043\PhpParser\Node\Expr;
use ConfigTransformer202202043\PhpParser\Node\Stmt;
use ConfigTransformer202202043\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202202043\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer202202043\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\ConfigTransformer202202043\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer202202043\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202202043\PhpParser\Node\Expr) {
            return new \ConfigTransformer202202043\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
