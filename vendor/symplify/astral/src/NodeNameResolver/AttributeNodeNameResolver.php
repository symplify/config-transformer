<?php

declare (strict_types=1);
namespace ConfigTransformer202112108\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112108\PhpParser\Node;
use ConfigTransformer202112108\PhpParser\Node\Attribute;
use ConfigTransformer202112108\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202112108\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112108\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112108\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202112108\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
