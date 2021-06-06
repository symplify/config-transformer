<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer20210606\PhpParser\Node\Arg;
use ConfigTransformer20210606\PhpParser\Node\Expr;
use ConfigTransformer20210606\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer20210606\PhpParser\Node\Name\FullyQualified;
final class ServiceReferenceExprResolver
{
    /**
     * @var StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\ConfigTransformer20210606\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \ConfigTransformer20210606\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \ConfigTransformer20210606\PhpParser\Node\Arg($expr)];
        return new \ConfigTransformer20210606\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer20210606\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
