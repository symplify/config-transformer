<?php

declare (strict_types=1);
namespace ConfigTransformer2021120710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021120710\PhpParser\Node;
use ConfigTransformer2021120710\PhpParser\Node\Expr;
use ConfigTransformer2021120710\PhpParser\Node\Param;
use ConfigTransformer2021120710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer2021120710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021120710\PhpParser\Node\Param;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer2021120710\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
