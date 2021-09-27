<?php

declare (strict_types=1);
namespace ConfigTransformer202109278\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109278\PhpParser\Node;
use ConfigTransformer202109278\PhpParser\Node\Arg;
use ConfigTransformer202109278\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202109278\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109278\PhpParser\Node\Arg;
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
