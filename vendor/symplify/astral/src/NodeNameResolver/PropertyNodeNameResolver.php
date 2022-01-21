<?php

declare (strict_types=1);
namespace ConfigTransformer202201211\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201211\PhpParser\Node;
use ConfigTransformer202201211\PhpParser\Node\Stmt\Property;
use ConfigTransformer202201211\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202201211\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201211\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201211\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer202201211\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
