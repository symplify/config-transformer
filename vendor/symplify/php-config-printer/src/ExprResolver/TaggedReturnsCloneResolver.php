<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer2021061210\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021061210\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2021061210\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
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
    public function __construct(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider, \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
    }
    public function resolve(\ConfigTransformer2021061210\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer2021061210\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $functionName = $this->symfonyFunctionNameProvider->provideRefOrService();
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
        return new \ConfigTransformer2021061210\PhpParser\Node\Expr\Array_([new \ConfigTransformer2021061210\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
