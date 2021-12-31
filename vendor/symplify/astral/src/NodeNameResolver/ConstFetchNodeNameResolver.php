<?php

declare (strict_types=1);
namespace ConfigTransformer202112316\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112316\PhpParser\Node;
use ConfigTransformer202112316\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202112316\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202112316\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112316\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112316\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202112316\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
