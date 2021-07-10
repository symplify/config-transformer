<?php

declare (strict_types=1);
namespace ConfigTransformer202107107\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107107\PhpParser\Node;
use ConfigTransformer202107107\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202107107\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202107107\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202107107\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        // convention to save uppercase and lowercase functions for each name
        return $node->name->toLowerString();
    }
}
