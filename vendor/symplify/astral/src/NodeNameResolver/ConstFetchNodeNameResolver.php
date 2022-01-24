<?php

declare (strict_types=1);
namespace ConfigTransformer202201244\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201244\PhpParser\Node;
use ConfigTransformer202201244\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202201244\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202201244\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201244\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202201244\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202201244\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
