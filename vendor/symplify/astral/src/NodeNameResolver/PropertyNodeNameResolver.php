<?php

declare (strict_types=1);
namespace ConfigTransformer202107054\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107054\PhpParser\Node;
use ConfigTransformer202107054\PhpParser\Node\Stmt\Property;
use ConfigTransformer202107054\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202107054\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107054\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202107054\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer202107054\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
