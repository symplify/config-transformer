<?php

declare (strict_types=1);
namespace ConfigTransformer2021081110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021081110\PhpParser\Node;
use ConfigTransformer2021081110\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer2021081110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer2021081110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021081110\PhpParser\Node\Stmt\ClassLike;
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
