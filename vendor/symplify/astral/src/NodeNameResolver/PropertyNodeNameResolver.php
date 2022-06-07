<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022060710\PhpParser\Node;
use ConfigTransformer2022060710\PhpParser\Node\Stmt\Property;
use ConfigTransformer2022060710\Symplify\Astral\Contract\NodeNameResolverInterface;
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
