<?php

declare (strict_types=1);
namespace ConfigTransformer2021120810\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021120810\PhpParser\Node;
use ConfigTransformer2021120810\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021120810\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer2021120810\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021120810\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
