<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202204166\PhpParser\Node;
use ConfigTransformer202204166\PhpParser\Node\Expr;
use ConfigTransformer202204166\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202204166\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202204166\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204166\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202204166\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202204166\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202204166\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
