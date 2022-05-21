<?php

declare (strict_types=1);
namespace ConfigTransformer202205218\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202205218\PhpParser\Node\Expr\Array_;
use ConfigTransformer202205218\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202205218\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202205218\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer202205218\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202205218\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202205218\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, \ConfigTransformer202205218\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE);
        return new \ConfigTransformer202205218\PhpParser\Node\Expr\Array_([new \ConfigTransformer202205218\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
