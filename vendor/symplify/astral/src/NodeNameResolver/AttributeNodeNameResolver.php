<?php

declare (strict_types=1);
namespace ConfigTransformer202202218\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202218\PhpParser\Node;
use ConfigTransformer202202218\PhpParser\Node\Attribute;
use ConfigTransformer202202218\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202202218\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202218\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202218\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202202218\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
