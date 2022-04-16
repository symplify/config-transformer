<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202204166\PhpParser\Node;
use ConfigTransformer202204166\PhpParser\Node\Arg;
use ConfigTransformer202204166\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202204166\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204166\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202204166\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer202204166\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
