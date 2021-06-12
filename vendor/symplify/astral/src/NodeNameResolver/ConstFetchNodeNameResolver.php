<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021061210\PhpParser\Node;
use ConfigTransformer2021061210\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021061210\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer2021061210\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021061210\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021061210\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer2021061210\PhpParser\Node $node) : ?string
    {
        // convention to save uppercase and lowercase functions for each name
        return $node->name->toLowerString();
    }
}
