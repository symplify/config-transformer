<?php

declare (strict_types=1);
namespace ConfigTransformer20220613\Symplify\Astral\NodeNameResolver;

use ConfigTransformer20220613\PhpParser\Node;
use ConfigTransformer20220613\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer20220613\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(Node $node) : ?string
    {
        return $node->name->toString();
    }
}
