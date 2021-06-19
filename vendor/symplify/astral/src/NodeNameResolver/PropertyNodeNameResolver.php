<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021061910\PhpParser\Node;
use ConfigTransformer2021061910\PhpParser\Node\Stmt\Property;
use ConfigTransformer2021061910\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer2021061910\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021061910\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021061910\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer2021061910\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
