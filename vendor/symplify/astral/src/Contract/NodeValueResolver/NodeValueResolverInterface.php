<?php

declare (strict_types=1);
namespace ConfigTransformer202203032\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer202203032\PhpParser\Node\Expr;
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
    public function resolve(\ConfigTransformer202203032\PhpParser\Node\Expr $expr, string $currentFilePath);
}
