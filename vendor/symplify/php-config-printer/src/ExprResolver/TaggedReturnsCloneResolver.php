<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202206075\PhpParser\Node\Expr\Array_;
use ConfigTransformer202206075\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202206075\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(TaggedValue $taggedValue) : Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, FunctionName::SERVICE);
        return new Array_([new ArrayItem($funcCall)]);
    }
}
