<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer20210606\PhpParser\Node\Expr;
use ConfigTransformer20210606\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer20210606\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer20210606\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer20210606\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer20210606\PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        $functionName = \ConfigTransformer20210606\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
    }
}
