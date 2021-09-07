<?php

declare (strict_types=1);
namespace ConfigTransformer2021090710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021090710\PhpParser\Node;
use ConfigTransformer2021090710\PhpParser\Node\Attribute;
use ConfigTransformer2021090710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer2021090710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021090710\PhpParser\Node\Attribute;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
