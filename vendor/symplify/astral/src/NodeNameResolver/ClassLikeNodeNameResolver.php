<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206072\PhpParser\Node;
use ConfigTransformer202206072\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202206072\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(Node $node) : ?string
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
