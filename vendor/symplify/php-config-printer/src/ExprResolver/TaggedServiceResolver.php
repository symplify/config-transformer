<?php

declare (strict_types=1);
namespace ConfigTransformer202202134\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202202134\PhpParser\Node\Expr;
use ConfigTransformer202202134\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202202134\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202202134\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202202134\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202202134\PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        $functionName = \ConfigTransformer202202134\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
    }
}
