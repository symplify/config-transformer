<?php

declare (strict_types=1);
namespace ConfigTransformer202111169\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202111169\PhpParser\Node;
use ConfigTransformer202111169\PhpParser\Node\Arg;
use ConfigTransformer202111169\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202111169\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202111169\PhpParser\Node\Arg;
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
