<?php

declare (strict_types=1);
namespace ConfigTransformer202110315\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202110315\PhpParser\Node;
use ConfigTransformer202110315\PhpParser\Node\Attribute;
use ConfigTransformer202110315\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202110315\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202110315\PhpParser\Node\Attribute;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
