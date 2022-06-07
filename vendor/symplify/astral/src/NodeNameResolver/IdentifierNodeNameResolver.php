<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220607\PhpParser\Node;
use ConfigTransformer20220607\PhpParser\Node\Identifier;
use ConfigTransformer20220607\PhpParser\Node\Name;
use ConfigTransformer20220607\Symplify\Astral\Contract\NodeNameResolverInterface;
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
