<?php

declare (strict_types=1);
namespace ConfigTransformer202202215\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer202202215\PhpParser\Node\Expr;
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
    public function resolve(\ConfigTransformer202202215\PhpParser\Node\Expr $expr, string $currentFilePath);
}
