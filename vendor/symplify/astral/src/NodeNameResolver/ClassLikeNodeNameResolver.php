<?php

declare (strict_types=1);
namespace ConfigTransformer202202249\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202249\PhpParser\Node;
use ConfigTransformer202202249\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202202249\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202202249\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202249\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202249\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer202202249\PhpParser\Node $node) : ?string
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
