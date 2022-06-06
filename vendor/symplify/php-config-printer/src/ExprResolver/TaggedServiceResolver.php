<?php

declare (strict_types=1);
namespace ConfigTransformer202206069\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202206069\PhpParser\Node\Expr;
use ConfigTransformer202206069\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202206069\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202206069\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202206069\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202206069\PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, \ConfigTransformer202206069\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE);
    }
}
