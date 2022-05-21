<?php

declare (strict_types=1);
namespace ConfigTransformer202205215\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202205215\PhpParser\Node;
use ConfigTransformer202205215\PhpParser\Node\Expr;
use ConfigTransformer202205215\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202205215\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202205215\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205215\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202205215\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202205215\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202205215\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
