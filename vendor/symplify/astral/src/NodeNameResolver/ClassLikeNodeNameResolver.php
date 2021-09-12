<?php

declare (strict_types=1);
namespace ConfigTransformer202109129\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109129\PhpParser\Node;
use ConfigTransformer202109129\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202109129\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202109129\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109129\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if (\property_exists($node, 'namespacedName')) {
            return (string) $node->namespacedName;
        }
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
