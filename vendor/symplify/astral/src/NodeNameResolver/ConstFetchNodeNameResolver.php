<?php

declare (strict_types=1);
namespace ConfigTransformer202202199\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202199\PhpParser\Node;
use ConfigTransformer202202199\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202202199\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer202202199\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202199\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202199\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer202202199\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
