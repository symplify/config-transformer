<?php

declare (strict_types=1);
namespace ConfigTransformer202108251\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202108251\PhpParser\Node;
use ConfigTransformer202108251\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202108251\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202108251\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202108251\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
