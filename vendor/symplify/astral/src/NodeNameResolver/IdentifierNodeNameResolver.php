<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022053010\PhpParser\Node;
use ConfigTransformer2022053010\PhpParser\Node\Identifier;
use ConfigTransformer2022053010\PhpParser\Node\Name;
use ConfigTransformer2022053010\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer2022053010\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022053010\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer2022053010\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer2022053010\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer2022053010\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
