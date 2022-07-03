<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202207\PhpParser\Node\Arg;
use ConfigTransformer202207\PhpParser\Node\Expr;
use ConfigTransformer202207\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202207\PhpParser\Node\Name\FullyQualified;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class ServiceReferenceExprResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    /**
     * @param FunctionName::* $functionName
     */
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new Arg($expr)];
        return new FuncCall(new FullyQualified($functionName), $args);
    }
}
