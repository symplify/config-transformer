<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021082410\PhpParser\Node;
use ConfigTransformer2021082410\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer2021082410\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer2021082410\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021082410\PhpParser\Node\Stmt\Namespace_;
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
