<?php

declare (strict_types=1);
namespace ConfigTransformer202110143\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202110143\PhpParser\Node;
use ConfigTransformer202110143\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202110143\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202110143\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202110143\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
