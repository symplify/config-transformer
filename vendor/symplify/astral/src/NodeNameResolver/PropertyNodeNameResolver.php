<?php

declare (strict_types=1);
namespace ConfigTransformer202206\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206\PhpParser\Node;
use ConfigTransformer202206\PhpParser\Node\Stmt\Property;
use ConfigTransformer202206\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
