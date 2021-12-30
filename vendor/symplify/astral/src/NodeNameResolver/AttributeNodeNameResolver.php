<?php

declare (strict_types=1);
namespace ConfigTransformer202112302\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112302\PhpParser\Node;
use ConfigTransformer202112302\PhpParser\Node\Attribute;
use ConfigTransformer202112302\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202112302\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112302\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112302\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202112302\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
