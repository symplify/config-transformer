<?php

declare (strict_types=1);
namespace ConfigTransformer202109302\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202109302\PhpParser\Node\Expr;
use ConfigTransformer202109302\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202109302\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202109302\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202109302\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202109302\PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        $functionName = \ConfigTransformer202109302\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
    }
}
