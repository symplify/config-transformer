<?php

declare (strict_types=1);
namespace ConfigTransformer202206052\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206052\PhpParser\Node;
use ConfigTransformer202206052\PhpParser\Node\Stmt\Property;
use ConfigTransformer202206052\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202206052\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206052\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206052\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer202206052\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
