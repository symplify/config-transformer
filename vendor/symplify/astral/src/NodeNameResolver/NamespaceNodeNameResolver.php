<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021122310\PhpParser\Node;
use ConfigTransformer2021122310\PhpParser\Node\Stmt\Namespace_;
use ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021122310\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021122310\PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(\ConfigTransformer2021122310\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
