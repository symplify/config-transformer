<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022020510\PhpParser\Node;
use ConfigTransformer2022020510\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2022020510\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ClassMethodNodeNameResolver implements \ConfigTransformer2022020510\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022020510\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022020510\PhpParser\Node\Stmt\ClassMethod;
    }
    /**
     * @param ClassMethod $node
     */
    public function resolve(\ConfigTransformer2022020510\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
