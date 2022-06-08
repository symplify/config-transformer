<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220608\PhpParser\Node;
use ConfigTransformer20220608\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer20220608\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
