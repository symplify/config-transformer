<?php

declare (strict_types=1);
namespace ConfigTransformer202205128\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202205128\PhpParser\Node;
use ConfigTransformer202205128\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202205128\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202205128\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205128\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202205128\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202205128\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
