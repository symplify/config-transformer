<?php

declare (strict_types=1);
namespace ConfigTransformer202201245\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202201245\PhpParser\Node\Expr\Array_;
use ConfigTransformer202201245\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202201245\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202201245\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202201245\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202201245\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202201245\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, \ConfigTransformer202201245\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE);
        return new \ConfigTransformer202201245\PhpParser\Node\Expr\Array_([new \ConfigTransformer202201245\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
