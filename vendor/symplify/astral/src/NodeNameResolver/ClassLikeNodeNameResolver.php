<?php

declare (strict_types=1);
namespace ConfigTransformer202206019\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206019\PhpParser\Node;
use ConfigTransformer202206019\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202206019\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202206019\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206019\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206019\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer202206019\PhpParser\Node $node) : ?string
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
