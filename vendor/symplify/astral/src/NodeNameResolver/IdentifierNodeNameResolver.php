<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021122310\PhpParser\Node;
use ConfigTransformer2021122310\PhpParser\Node\Identifier;
use ConfigTransformer2021122310\PhpParser\Node\Name;
use ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021122310\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer2021122310\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer2021122310\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer2021122310\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
