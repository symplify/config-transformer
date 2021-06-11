<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106110\PhpParser\Node;
use ConfigTransformer202106110\PhpParser\Node\Attribute;
use ConfigTransformer202106110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer202106110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106110\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer202106110\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}