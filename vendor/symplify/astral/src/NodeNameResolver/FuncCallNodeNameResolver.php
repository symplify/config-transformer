<?php

declare (strict_types=1);
namespace ConfigTransformer202202202\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202202\PhpParser\Node;
use ConfigTransformer202202202\PhpParser\Node\Expr;
use ConfigTransformer202202202\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202202202\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer202202202\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202202\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202202\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer202202202\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer202202202\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
