<?php

declare (strict_types=1);
namespace ConfigTransformer202109077\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109077\PhpParser\Node;
use ConfigTransformer202109077\PhpParser\Node\Expr;
use ConfigTransformer202109077\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202109077\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202109077\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109077\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202109077\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
