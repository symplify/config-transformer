<?php

declare (strict_types=1);
namespace ConfigTransformer202206063\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206063\PhpParser\Node;
use ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202206063\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202206063\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206063\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206063\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202206063\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
