<?php

declare (strict_types=1);
namespace ConfigTransformer202109173\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202109173\PhpParser\Node;
use ConfigTransformer202109173\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202109173\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202109173\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202109173\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
