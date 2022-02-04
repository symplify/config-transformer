<?php

declare (strict_types=1);
namespace ConfigTransformer202202043\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202043\PhpParser\Node;
use ConfigTransformer202202043\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202202043\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202202043\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202043\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202043\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer202202043\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
