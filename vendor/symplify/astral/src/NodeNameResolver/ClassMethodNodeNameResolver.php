<?php

declare (strict_types=1);
namespace ConfigTransformer202202180\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202202180\PhpParser\Node;
use ConfigTransformer202202180\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202202180\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202202180\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202180\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202202180\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202202180\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
