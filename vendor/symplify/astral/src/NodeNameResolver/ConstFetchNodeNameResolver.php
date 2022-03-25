<?php

declare (strict_types=1);
namespace ConfigTransformer202203257\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202203257\PhpParser\Node;
use ConfigTransformer202203257\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202203257\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202203257\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203257\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202203257\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202203257\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
