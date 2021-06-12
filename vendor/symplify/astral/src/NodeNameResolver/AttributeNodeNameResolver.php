<?php

declare (strict_types=1);
namespace ConfigTransformer202106124\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106124\PhpParser\Node;
use ConfigTransformer202106124\PhpParser\Node\Attribute;
use ConfigTransformer202106124\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202106124\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106124\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106124\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202106124\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
