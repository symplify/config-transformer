<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021061210\PhpParser\Node;
use ConfigTransformer2021061210\PhpParser\Node\Identifier;
use ConfigTransformer2021061210\PhpParser\Node\Name;
use ConfigTransformer2021061210\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer2021061210\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021061210\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer2021061210\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer2021061210\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer2021061210\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
