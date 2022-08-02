<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202208\PhpParser\Node;
use ConfigTransformer202208\PhpParser\Node\Identifier;
use ConfigTransformer202208\PhpParser\Node\Name;
use ConfigTransformer202208\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        if ($node instanceof Identifier) {
            return \true;
        }
        return $node instanceof Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(Node $node) : ?string
    {
        return (string) $node;
    }
}
