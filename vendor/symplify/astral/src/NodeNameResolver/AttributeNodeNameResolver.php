<?php

declare (strict_types=1);
namespace ConfigTransformer20220611\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220611\PhpParser\Node;
use ConfigTransformer20220611\PhpParser\Node\Attribute;
use ConfigTransformer20220611\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(Node $node) : ?string
    {
        return $node->name->toString();
    }
}
