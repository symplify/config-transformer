<?php

declare (strict_types=1);
namespace ConfigTransformer202109062\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109062\PhpParser\Node;
use ConfigTransformer202109062\PhpParser\Node\Stmt\Property;
use ConfigTransformer202109062\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202109062\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109062\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
