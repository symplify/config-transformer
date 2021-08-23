<?php

declare (strict_types=1);
namespace ConfigTransformer202108236\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202108236\PhpParser\Node;
use ConfigTransformer202108236\PhpParser\Node\Expr;
use ConfigTransformer202108236\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202108236\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202108236\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202108236\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202108236\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
