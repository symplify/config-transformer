<?php

declare (strict_types=1);
namespace ConfigTransformer202204298\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202204298\PhpParser\Node;
use ConfigTransformer202204298\PhpParser\Node\Stmt\Property;
use ConfigTransformer202204298\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202204298\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204298\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202204298\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer202204298\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
