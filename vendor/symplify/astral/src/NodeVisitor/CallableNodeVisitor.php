<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\Symplify\Astral\NodeVisitor;

use ConfigTransformer2021120410\PhpParser\Node;
use ConfigTransformer2021120410\PhpParser\Node\Expr;
use ConfigTransformer2021120410\PhpParser\Node\Stmt;
use ConfigTransformer2021120410\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021120410\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer2021120410\PhpParser\NodeVisitorAbstract
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
        if ($originalNode instanceof \ConfigTransformer2021120410\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer2021120410\PhpParser\Node\Expr) {
            return new \ConfigTransformer2021120410\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
