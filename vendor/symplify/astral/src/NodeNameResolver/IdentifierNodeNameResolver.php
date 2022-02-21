<?php

declare (strict_types=1);
namespace ConfigTransformer202202210\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202210\PhpParser\Node;
use ConfigTransformer202202210\PhpParser\Node\Identifier;
use ConfigTransformer202202210\PhpParser\Node\Name;
use ConfigTransformer202202210\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer202202210\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202210\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer202202210\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer202202210\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer202202210\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
