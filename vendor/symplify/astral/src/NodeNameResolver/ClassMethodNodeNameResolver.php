<?php

declare (strict_types=1);
namespace ConfigTransformer2021090710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021090710\PhpParser\Node;
use ConfigTransformer2021090710\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2021090710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer2021090710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021090710\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        return $node->name->toString();
    }
}
