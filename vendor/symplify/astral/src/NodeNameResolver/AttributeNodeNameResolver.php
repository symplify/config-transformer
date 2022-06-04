<?php

declare (strict_types=1);
namespace ConfigTransformer202206045\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206045\PhpParser\Node;
use ConfigTransformer202206045\PhpParser\Node\Attribute;
use ConfigTransformer202206045\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202206045\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206045\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206045\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202206045\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
