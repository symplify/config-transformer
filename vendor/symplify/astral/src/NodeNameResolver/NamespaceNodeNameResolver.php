<?php

declare (strict_types=1);
namespace ConfigTransformer202204298\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202204298\PhpParser\Node;
use ConfigTransformer202204298\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202204298\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202204298\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204298\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202204298\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer202204298\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
