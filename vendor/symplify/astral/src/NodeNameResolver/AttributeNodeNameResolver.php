<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022022110\PhpParser\Node;
use ConfigTransformer2022022110\PhpParser\Node\Attribute;
use ConfigTransformer2022022110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \ConfigTransformer2022022110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022022110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022022110\PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\ConfigTransformer2022022110\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
