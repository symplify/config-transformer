<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022020510\PhpParser\Node;
use ConfigTransformer2022020510\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2022020510\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \ConfigTransformer2022020510\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022020510\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022020510\PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param ConstFetch $node
     */
    public function resolve(\ConfigTransformer2022020510\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
