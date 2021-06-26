<?php

declare (strict_types=1);
namespace ConfigTransformer202106263\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202106263\PhpParser\Node;
use ConfigTransformer202106263\PhpParser\Node\Arg;
use ConfigTransformer202106263\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202106263\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106263\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202106263\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer202106263\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
