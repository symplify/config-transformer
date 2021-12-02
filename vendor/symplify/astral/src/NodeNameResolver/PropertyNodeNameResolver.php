<?php

declare (strict_types=1);
namespace ConfigTransformer202112023\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112023\PhpParser\Node;
use ConfigTransformer202112023\PhpParser\Node\Stmt\Property;
use ConfigTransformer202112023\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202112023\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202112023\PhpParser\Node\Stmt\Property;
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
