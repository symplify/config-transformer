<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022053010\PhpParser\Node;
use ConfigTransformer2022053010\PhpParser\Node\Arg;
use ConfigTransformer2022053010\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer2022053010\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022053010\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022053010\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer2022053010\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
