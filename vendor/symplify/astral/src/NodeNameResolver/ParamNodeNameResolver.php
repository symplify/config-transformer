<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021070510\PhpParser\Node;
use ConfigTransformer2021070510\PhpParser\Node\Expr;
use ConfigTransformer2021070510\PhpParser\Node\Param;
use ConfigTransformer2021070510\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer2021070510\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021070510\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2021070510\PhpParser\Node\Param;
    }
    /**
     * @param Param $node
     */
    public function resolve(\ConfigTransformer2021070510\PhpParser\Node $node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer2021070510\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
