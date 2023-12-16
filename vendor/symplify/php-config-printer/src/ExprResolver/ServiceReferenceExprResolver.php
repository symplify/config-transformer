<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformerPrefix202312\PhpParser\Node\Arg;
use ConfigTransformerPrefix202312\PhpParser\Node\Expr;
use ConfigTransformerPrefix202312\PhpParser\Node\Expr\FuncCall;
use ConfigTransformerPrefix202312\PhpParser\Node\Name\FullyQualified;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class ServiceReferenceExprResolver
{
    /**
     * @readonly
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
