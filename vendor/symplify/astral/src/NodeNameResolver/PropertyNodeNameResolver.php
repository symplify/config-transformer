<?php

declare (strict_types=1);
namespace ConfigTransformer202202249\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202249\PhpParser\Node;
use ConfigTransformer202202249\PhpParser\Node\Stmt\Property;
use ConfigTransformer202202249\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202202249\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202249\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202249\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer202202249\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
