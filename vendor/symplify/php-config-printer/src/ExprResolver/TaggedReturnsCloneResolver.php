<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformerPrefix202401\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedReturnsCloneResolver
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(TaggedValue $taggedValue) : Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $expr = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, FunctionName::SERVICE);
        return new Array_([new ArrayItem($expr)]);
    }
}
