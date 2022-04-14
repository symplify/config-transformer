<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer2022041410\PhpParser\Node\Arg;
use ConfigTransformer2022041410\PhpParser\Node\Expr;
use ConfigTransformer2022041410\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2022041410\PhpParser\Node\Name\FullyQualified;
final class ServiceReferenceExprResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\ConfigTransformer2022041410\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \ConfigTransformer2022041410\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \ConfigTransformer2022041410\PhpParser\Node\Arg($expr)];
        return new \ConfigTransformer2022041410\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer2022041410\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
