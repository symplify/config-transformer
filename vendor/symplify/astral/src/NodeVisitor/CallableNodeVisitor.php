<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\Astral\NodeVisitor;

use ConfigTransformer2021123110\PhpParser\Node;
use ConfigTransformer2021123110\PhpParser\Node\Expr;
use ConfigTransformer2021123110\PhpParser\Node\Stmt;
use ConfigTransformer2021123110\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021123110\PhpParser\NodeVisitorAbstract;
final class CallableNodeVisitor extends \ConfigTransformer2021123110\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\ConfigTransformer2021123110\PhpParser\Node $node)
    {
        $originalNode = $node;
        $callable = $this->callable;
        /** @var int|Node|null $newNode */
        $newNode = $callable($node);
        if ($originalNode instanceof \ConfigTransformer2021123110\PhpParser\Node\Stmt && $newNode instanceof \ConfigTransformer2021123110\PhpParser\Node\Expr) {
            return new \ConfigTransformer2021123110\PhpParser\Node\Stmt\Expression($newNode);
        }
        return $newNode;
    }
}
