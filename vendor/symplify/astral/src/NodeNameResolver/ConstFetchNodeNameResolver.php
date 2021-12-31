<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021123110\PhpParser\Node;
use ConfigTransformer2021123110\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021123110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021123110\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer2021123110\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
