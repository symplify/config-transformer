<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022060710\PhpParser\Node;
use ConfigTransformer2022060710\PhpParser\Node\Expr;
use ConfigTransformer2022060710\PhpParser\Node\Param;
use ConfigTransformer2022060710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Param;
    }
    /**
     * @param Param $node
     */
    public function resolve(Node $node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof Expr) {
            return null;
        }
        return $paramName;
    }
}
