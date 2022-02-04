<?php

declare (strict_types=1);
namespace ConfigTransformer202202043\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202202043\PhpParser\Node\Expr\Array_;
use ConfigTransformer202202043\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202202043\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202202043\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202202043\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202202043\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202202043\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, \ConfigTransformer202202043\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE);
        return new \ConfigTransformer202202043\PhpParser\Node\Expr\Array_([new \ConfigTransformer202202043\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
