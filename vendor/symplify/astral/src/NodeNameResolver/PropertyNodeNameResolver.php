<?php

declare (strict_types=1);
namespace ConfigTransformer20220613\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220613\PhpParser\Node;
use ConfigTransformer20220613\PhpParser\Node\Stmt\Property;
use ConfigTransformer20220613\Symplify\Astral\Contract\NodeNameResolverInterface;
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
