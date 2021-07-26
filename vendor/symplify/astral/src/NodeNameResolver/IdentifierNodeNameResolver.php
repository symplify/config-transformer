<?php

declare (strict_types=1);
namespace ConfigTransformer202107264\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107264\PhpParser\Node;
use ConfigTransformer202107264\PhpParser\Node\Identifier;
use ConfigTransformer202107264\PhpParser\Node\Name;
use ConfigTransformer202107264\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer202107264\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        if ($node instanceof \ConfigTransformer202107264\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer202107264\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve($node) : ?string
    {
        return (string) $node;
    }
}
