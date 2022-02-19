<?php

declare (strict_types=1);
namespace ConfigTransformer202202198\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202198\PhpParser\Node;
use ConfigTransformer202202198\PhpParser\Node\Attribute;
use ConfigTransformer202202198\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202202198\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202198\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202198\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202202198\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
