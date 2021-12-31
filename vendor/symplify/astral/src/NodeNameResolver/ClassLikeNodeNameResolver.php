<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021123110\PhpParser\Node;
use ConfigTransformer2021123110\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021123110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021123110\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer2021123110\PhpParser\Node $node) : ?string
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
