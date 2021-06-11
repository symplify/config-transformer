<?php

declare (strict_types=1);
namespace ConfigTransformer202106115\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202106115\PhpParser\Node\Expr\Array_;
use ConfigTransformer202106115\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202106115\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
final class TaggedReturnsCloneResolver
{
    /**
     * @var ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    /**
     * @var SymfonyFunctionNameProvider
     */
    private $symfonyFunctionNameProvider;
    public function __construct(\ConfigTransformer202106115\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider, \ConfigTransformer202106115\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
    }
    public function resolve(\ConfigTransformer202106115\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202106115\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $functionName = $this->symfonyFunctionNameProvider->provideRefOrService();
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
        return new \ConfigTransformer202106115\PhpParser\Node\Expr\Array_([new \ConfigTransformer202106115\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
