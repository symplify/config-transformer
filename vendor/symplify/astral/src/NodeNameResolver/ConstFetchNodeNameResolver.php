<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021070510\PhpParser\Node;
use ConfigTransformer2021070510\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021070510\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer2021070510\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021070510\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021070510\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer2021070510\PhpParser\Node $node) : ?string
    {
        // convention to save uppercase and lowercase functions for each name
        return $node->name->toLowerString();
    }
}
