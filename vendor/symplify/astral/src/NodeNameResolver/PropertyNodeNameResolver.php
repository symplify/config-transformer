<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021110110\PhpParser\Node;
use ConfigTransformer2021110110\PhpParser\Node\Stmt\Property;
use ConfigTransformer2021110110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer2021110110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021110110\PhpParser\Node\Stmt\Property;
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
