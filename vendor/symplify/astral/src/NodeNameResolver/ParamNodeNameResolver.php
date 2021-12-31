<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021123110\PhpParser\Node;
use ConfigTransformer2021123110\PhpParser\Node\Expr;
use ConfigTransformer2021123110\PhpParser\Node\Param;
use ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer2021123110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021123110\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021123110\PhpParser\Node\Param;
    }
    /**
     * @param Param $node
     */
    public function resolve(\ConfigTransformer2021123110\PhpParser\Node $node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer2021123110\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
