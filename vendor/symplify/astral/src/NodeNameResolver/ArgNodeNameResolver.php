<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206077\PhpParser\Node;
use ConfigTransformer202206077\PhpParser\Node\Arg;
use ConfigTransformer202206077\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
