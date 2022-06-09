<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220609\PhpParser\Node;
use ConfigTransformer20220609\PhpParser\Node\Expr;
use ConfigTransformer20220609\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer20220609\Symplify\Astral\Contract\NodeNameResolverInterface;
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
