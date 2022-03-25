<?php

declare (strict_types=1);
namespace ConfigTransformer202203250\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202203250\PhpParser\Node;
use ConfigTransformer202203250\PhpParser\Node\Expr;
use ConfigTransformer202203250\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202203250\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202203250\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203250\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202203250\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202203250\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202203250\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
