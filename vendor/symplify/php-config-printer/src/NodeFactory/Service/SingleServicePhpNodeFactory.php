<?php

declare (strict_types=1);
namespace ConfigTransformer2021091310\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer2021091310\PhpParser\BuilderHelpers;
use ConfigTransformer2021091310\PhpParser\Node\Arg;
use ConfigTransformer2021091310\PhpParser\Node\Expr;
use ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021091310\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021091310\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer2021091310\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
final class SingleServicePhpNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021091310\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createProperties(\ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall $methodCall, array $properties) : \ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall
    {
        foreach ($properties as $name => $value) {
            $args = $this->argsNodeFactory->createFromValues([$name, $value]);
            $methodCall = new \ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall($methodCall, 'property', $args);
        }
        return $methodCall;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createCalls(\ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall $methodCall, array $calls) : \ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall
    {
        foreach ($calls as $call) {
            // @todo can be more items
            $args = [];
            $methodName = $this->resolveCallMethod($call);
            $args[] = new \ConfigTransformer2021091310\PhpParser\Node\Arg($methodName);
            $argumentsExpr = $this->resolveCallArguments($call);
            $args[] = new \ConfigTransformer2021091310\PhpParser\Node\Arg($argumentsExpr);
            $returnCloneExpr = $this->resolveCallReturnClone($call);
            if ($returnCloneExpr !== null) {
                $args[] = new \ConfigTransformer2021091310\PhpParser\Node\Arg($returnCloneExpr);
            }
            $currentArray = \current($call);
            if ($currentArray instanceof \ConfigTransformer2021091310\Symfony\Component\Yaml\Tag\TaggedValue) {
                $args[] = new \ConfigTransformer2021091310\PhpParser\Node\Arg(\ConfigTransformer2021091310\PhpParser\BuilderHelpers::normalizeValue(\true));
            }
            $methodCall = new \ConfigTransformer2021091310\PhpParser\Node\Expr\MethodCall($methodCall, 'call', $args);
        }
        return $methodCall;
    }
    private function resolveCallMethod($call) : \ConfigTransformer2021091310\PhpParser\Node\Scalar\String_
    {
        return new \ConfigTransformer2021091310\PhpParser\Node\Scalar\String_($call[0] ?? $call['method'] ?? \key($call));
    }
    private function resolveCallArguments($call) : \ConfigTransformer2021091310\PhpParser\Node\Expr
    {
        $arguments = $call[1] ?? $call['arguments'] ?? \current($call);
        return $this->argsNodeFactory->resolveExpr($arguments);
    }
    private function resolveCallReturnClone(array $call) : ?\ConfigTransformer2021091310\PhpParser\Node\Expr
    {
        if (isset($call[2]) || isset($call['returns_clone'])) {
            $returnsCloneValue = $call[2] ?? $call['returns_clone'];
            return \ConfigTransformer2021091310\PhpParser\BuilderHelpers::normalizeValue($returnsCloneValue);
        }
        return null;
    }
}
