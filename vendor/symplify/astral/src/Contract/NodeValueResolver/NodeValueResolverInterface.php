<?php

declare (strict_types=1);
namespace ConfigTransformer202112195\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer202112195\PhpParser\Node\Expr;
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
    public function resolve(\ConfigTransformer202112195\PhpParser\Node\Expr $expr, string $currentFilePath);
}
