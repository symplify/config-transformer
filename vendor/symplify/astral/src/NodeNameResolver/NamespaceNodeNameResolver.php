<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022052210\PhpParser\Node;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer2022052210\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer2022052210\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022052210\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022052210\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer2022052210\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
