<?php

declare (strict_types=1);
namespace ConfigTransformer202203073\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202203073\PhpParser\Node;
use ConfigTransformer202203073\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202203073\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202203073\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203073\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202203073\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202203073\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
