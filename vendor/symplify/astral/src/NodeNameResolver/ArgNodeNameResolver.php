<?php

declare (strict_types=1);
namespace ConfigTransformer202108269\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202108269\PhpParser\Node;
use ConfigTransformer202108269\PhpParser\Node\Arg;
use ConfigTransformer202108269\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202108269\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202108269\PhpParser\Node\Arg;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
