<?php

declare (strict_types=1);
namespace ConfigTransformer2022010310\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022010310\PhpParser\Node;
use ConfigTransformer2022010310\PhpParser\Node\Expr;
use ConfigTransformer2022010310\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2022010310\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer2022010310\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022010310\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022010310\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer2022010310\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer2022010310\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
