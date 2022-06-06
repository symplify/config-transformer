<?php

declare (strict_types=1);
namespace ConfigTransformer202206069\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202206069\PhpParser\Node\Arg;
use ConfigTransformer202206069\PhpParser\Node\Expr;
use ConfigTransformer202206069\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202206069\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202206069\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class ServiceReferenceExprResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\ConfigTransformer202206069\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    /**
     * @param FunctionName::* $functionName
     */
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \ConfigTransformer202206069\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \ConfigTransformer202206069\PhpParser\Node\Arg($expr)];
        return new \ConfigTransformer202206069\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer202206069\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
