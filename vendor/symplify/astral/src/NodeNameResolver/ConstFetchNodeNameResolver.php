<?php

declare (strict_types=1);
namespace ConfigTransformer202206\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206\PhpParser\Node;
use ConfigTransformer202206\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202206\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(Node $node) : ?string
    {
        return $node->name->toString();
    }
}
