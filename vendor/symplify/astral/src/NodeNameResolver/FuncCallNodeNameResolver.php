<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206077\PhpParser\Node;
use ConfigTransformer202206077\PhpParser\Node\Expr;
use ConfigTransformer202206077\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202206077\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name instanceof Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
