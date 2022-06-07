<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202206079\PhpParser\Node;
use ConfigTransformer202206079\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202206079\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202206079\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206079\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202206079\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202206079\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
