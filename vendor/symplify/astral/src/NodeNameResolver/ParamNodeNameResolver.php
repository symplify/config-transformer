<?php

declare (strict_types=1);
namespace ConfigTransformer202110251\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202110251\PhpParser\Node;
use ConfigTransformer202110251\PhpParser\Node\Expr;
use ConfigTransformer202110251\PhpParser\Node\Param;
use ConfigTransformer202110251\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer202110251\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202110251\PhpParser\Node\Param;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer202110251\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
