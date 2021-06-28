<?php

declare (strict_types=1);
namespace ConfigTransformer202106280\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106280\PhpParser\Node;
use ConfigTransformer202106280\PhpParser\Node\Expr;
use ConfigTransformer202106280\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202106280\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202106280\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106280\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106280\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202106280\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202106280\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
