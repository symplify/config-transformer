<?php

declare (strict_types=1);
namespace ConfigTransformer2021071010\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer2021071010\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021071010\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2021071010\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer2021071010\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
final class TaggedReturnsCloneResolver
{
    /**
     * @var \Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider
     */
    private $symfonyFunctionNameProvider;
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\ConfigTransformer2021071010\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider, \ConfigTransformer2021071010\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer2021071010\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer2021071010\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $functionName = $this->symfonyFunctionNameProvider->provideRefOrService();
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
        return new \ConfigTransformer2021071010\PhpParser\Node\Expr\Array_([new \ConfigTransformer2021071010\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
