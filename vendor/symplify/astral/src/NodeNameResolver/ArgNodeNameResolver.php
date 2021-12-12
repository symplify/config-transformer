<?php

declare (strict_types=1);
namespace ConfigTransformer202112121\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112121\PhpParser\Node;
use ConfigTransformer202112121\PhpParser\Node\Arg;
use ConfigTransformer202112121\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202112121\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112121\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112121\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer202112121\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
