<?php

declare (strict_types=1);
namespace ConfigTransformer202202185\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202185\PhpParser\Node;
use ConfigTransformer202202185\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202202185\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202202185\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202185\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202185\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202202185\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
