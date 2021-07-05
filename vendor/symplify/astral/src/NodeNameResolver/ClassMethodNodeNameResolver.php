<?php

declare (strict_types=1);
namespace ConfigTransformer202107058\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202107058\PhpParser\Node;
use ConfigTransformer202107058\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202107058\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202107058\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107058\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202107058\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202107058\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
