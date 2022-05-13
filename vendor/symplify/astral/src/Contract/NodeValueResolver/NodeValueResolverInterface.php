<?php

declare (strict_types=1);
namespace ConfigTransformer2022051310\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer2022051310\PhpParser\Node\Expr;
/**
 * @template TExpr as Expr
 */
interface NodeValueResolverInterface
{
    /**
     * @return class-string<TExpr>
     */
    public function getType() : string;
    /**
     * @param TExpr $expr
     * @return mixed
     */
    public function resolve(\ConfigTransformer2022051310\PhpParser\Node\Expr $expr, string $currentFilePath);
}
