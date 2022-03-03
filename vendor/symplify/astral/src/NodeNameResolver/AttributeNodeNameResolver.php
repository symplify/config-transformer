<?php

declare (strict_types=1);
namespace ConfigTransformer202203038\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202203038\PhpParser\Node;
use ConfigTransformer202203038\PhpParser\Node\Attribute;
use ConfigTransformer202203038\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202203038\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203038\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202203038\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202203038\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
