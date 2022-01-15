<?php

declare (strict_types=1);
namespace ConfigTransformer202201151\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201151\PhpParser\Node;
use ConfigTransformer202201151\PhpParser\Node\Attribute;
use ConfigTransformer202201151\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202201151\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201151\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201151\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202201151\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
