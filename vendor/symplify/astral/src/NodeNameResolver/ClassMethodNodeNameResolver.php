<?php

declare (strict_types=1);
namespace ConfigTransformer202203054\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202203054\PhpParser\Node;
use ConfigTransformer202203054\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202203054\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer202203054\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203054\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202203054\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer202203054\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
