<?php

declare (strict_types=1);
namespace ConfigTransformer202108209\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202108209\PhpParser\Node;
use ConfigTransformer202108209\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202108209\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202108209\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202108209\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
