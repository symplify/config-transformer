<?php

declare (strict_types=1);
namespace ConfigTransformer202107036\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107036\PhpParser\Node;
use ConfigTransformer202107036\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202107036\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer202107036\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107036\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202107036\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer202107036\PhpParser\Node $node) : ?string
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
