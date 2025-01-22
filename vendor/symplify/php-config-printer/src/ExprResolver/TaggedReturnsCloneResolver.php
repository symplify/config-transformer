<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformerPrefix202501\PhpParser\Node\ArrayItem;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202501\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\Naming\ReferenceFunctionNameResolver;
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
        $expr = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, ReferenceFunctionNameResolver::resolve());
        return new Array_([new ArrayItem($expr)]);
    }
}
