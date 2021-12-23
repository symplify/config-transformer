<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021122310\PhpParser\Node;
use ConfigTransformer2021122310\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer2021122310\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021122310\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021122310\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer2021122310\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
