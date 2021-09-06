<?php

declare (strict_types=1);
namespace ConfigTransformer202109062\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202109062\PhpParser\Node\Expr;
use ConfigTransformer202109062\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202109062\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202109062\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202109062\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202109062\PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        $functionName = \ConfigTransformer202109062\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
    }
}
