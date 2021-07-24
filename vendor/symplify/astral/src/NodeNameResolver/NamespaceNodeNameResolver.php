<?php

declare (strict_types=1);
namespace ConfigTransformer202107245\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107245\PhpParser\Node;
use ConfigTransformer202107245\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202107245\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202107245\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202107245\PhpParser\Node\Stmt\Namespace_;
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
