<?php

declare (strict_types=1);
namespace ConfigTransformer202109294\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer202109294\PhpParser\Node\Expr;
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
     * @param \PhpParser\Node\Expr $expr
     * @return mixed
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath);
}
