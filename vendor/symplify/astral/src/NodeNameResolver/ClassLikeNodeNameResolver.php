<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022051110\PhpParser\Node;
use ConfigTransformer2022051110\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer2022051110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassLikeNodeNameResolver implements \ConfigTransformer2022051110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022051110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022051110\PhpParser\Node\Stmt\ClassLike;
    }
    /**
     * @param ClassLike $node
     */
    public function resolve(\ConfigTransformer2022051110\PhpParser\Node $node) : ?string
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
