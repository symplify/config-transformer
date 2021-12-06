<?php

declare (strict_types=1);
namespace ConfigTransformer202112063\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112063\PhpParser\Node;
use ConfigTransformer202112063\PhpParser\Node\Expr;
use ConfigTransformer202112063\PhpParser\Node\Param;
use ConfigTransformer202112063\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer202112063\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202112063\PhpParser\Node\Param;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer202112063\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
