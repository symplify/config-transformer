<?php

declare (strict_types=1);
namespace ConfigTransformer202206055\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206055\PhpParser\Node;
use ConfigTransformer202206055\PhpParser\Node\Attribute;
use ConfigTransformer202206055\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202206055\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206055\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206055\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202206055\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
