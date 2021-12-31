<?php

declare (strict_types=1);
namespace ConfigTransformer202112316\Symplify\Astral\NodeVisitor;

use ConfigTransformer202112316\PhpParser\Node;
use ConfigTransformer202112316\PhpParser\Node\Expr;
use ConfigTransformer202112316\PhpParser\Node\Stmt;
use ConfigTransformer202112316\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202112316\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer202112316\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\ConfigTransformer202112316\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer202112316\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer202112316\PhpParser\Node\Expr) {
            return new \ConfigTransformer202112316\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
