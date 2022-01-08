<?php

declare (strict_types=1);
namespace ConfigTransformer202201085\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201085\PhpParser\Node;
use ConfigTransformer202201085\PhpParser\Node\Attribute;
use ConfigTransformer202201085\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202201085\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201085\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201085\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202201085\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
