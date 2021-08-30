<?php

declare (strict_types=1);
namespace ConfigTransformer202108306\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202108306\PhpParser\Node;
use ConfigTransformer202108306\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202108306\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202108306\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202108306\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
