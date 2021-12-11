<?php

declare (strict_types=1);
namespace ConfigTransformer202112119\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112119\PhpParser\Node;
use ConfigTransformer202112119\PhpParser\Node\Identifier;
use ConfigTransformer202112119\PhpParser\Node\Name;
use ConfigTransformer202112119\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer202112119\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112119\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer202112119\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer202112119\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer202112119\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
