<?php

declare (strict_types=1);
namespace ConfigTransformer202202152\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202152\PhpParser\Node;
use ConfigTransformer202202152\PhpParser\Node\Arg;
use ConfigTransformer202202152\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202202152\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202152\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202152\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer202202152\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
