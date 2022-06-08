<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220608\PhpParser\Node;
use ConfigTransformer20220608\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer20220608\Symplify\Astral\Contract\NodeNameResolverInterface;
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
