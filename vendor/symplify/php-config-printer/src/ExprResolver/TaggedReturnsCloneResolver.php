<?php

declare (strict_types=1);
namespace ConfigTransformer202107088\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202107088\PhpParser\Node\Expr\Array_;
use ConfigTransformer202107088\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202107088\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202107088\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
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
    public function __construct(\ConfigTransformer202107088\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider, \ConfigTransformer202107088\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\ConfigTransformer202107088\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer202107088\PhpParser\Node\Expr\Array_
    {
        $serviceName = $taggedValue->getValue()[0];
        $functionName = $this->symfonyFunctionNameProvider->provideRefOrService();
        $funcCall = $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
        return new \ConfigTransformer202107088\PhpParser\Node\Expr\Array_([new \ConfigTransformer202107088\PhpParser\Node\Expr\ArrayItem($funcCall)]);
    }
}
