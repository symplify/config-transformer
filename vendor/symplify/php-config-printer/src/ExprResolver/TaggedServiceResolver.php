<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformerPrefix202302\PhpParser\Node\Expr;
use ConfigTransformerPrefix202302\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
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
    public function resolve(TaggedValue $taggedValue) : Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, FunctionName::INLINE_SERVICE);
    }
}
