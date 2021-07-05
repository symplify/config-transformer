<?php

declare (strict_types=1);
namespace ConfigTransformer202107054\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107054\PhpParser\Node;
use ConfigTransformer202107054\PhpParser\Node\Expr;
use ConfigTransformer202107054\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202107054\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202107054\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107054\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202107054\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202107054\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202107054\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
