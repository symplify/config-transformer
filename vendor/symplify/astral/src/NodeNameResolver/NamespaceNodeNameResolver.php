<?php

declare (strict_types=1);
namespace ConfigTransformer202112232\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112232\PhpParser\Node;
use ConfigTransformer202112232\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer202112232\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer202112232\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112232\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112232\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer202112232\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
