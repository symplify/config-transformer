<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022011110\PhpParser\Node;
use ConfigTransformer2022011110\PhpParser\Node\Stmt\Property;
use ConfigTransformer2022011110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer2022011110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022011110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022011110\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param Property $node
     */
    public function resolve(\ConfigTransformer2022011110\PhpParser\Node $node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
