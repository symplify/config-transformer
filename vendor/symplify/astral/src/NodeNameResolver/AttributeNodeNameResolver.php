<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022031610\PhpParser\Node;
use ConfigTransformer2022031610\PhpParser\Node\Attribute;
use ConfigTransformer2022031610\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer2022031610\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022031610\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022031610\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer2022031610\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
