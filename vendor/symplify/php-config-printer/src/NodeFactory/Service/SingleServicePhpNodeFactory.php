<?php

declare (strict_types=1);
namespace ConfigTransformer202108166\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202108166\PhpParser\BuilderHelpers;
use ConfigTransformer202108166\PhpParser\Node\Arg;
use ConfigTransformer202108166\PhpParser\Node\Expr;
use ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202108166\PhpParser\Node\Scalar\String_;
use ConfigTransformer202108166\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202108166\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
final class SingleServicePhpNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202108166\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createProperties(\ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall $methodCall, array $properties) : \ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall
    {
        foreach ($properties as $name => $value) {
            $args = $this->argsNodeFactory->createFromValues([$name, $value]);
            $methodCall = new \ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall($methodCall, 'property', $args);
        }
        return $methodCall;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createCalls(\ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall $methodCall, array $calls) : \ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall
    {
        foreach ($calls as $call) {
            // @todo can be more items
            $args = [];
            $methodName = $this->resolveCallMethod($call);
            $args[] = new \ConfigTransformer202108166\PhpParser\Node\Arg($methodName);
            $argumentsExpr = $this->resolveCallArguments($call);
            $args[] = new \ConfigTransformer202108166\PhpParser\Node\Arg($argumentsExpr);
            $returnCloneExpr = $this->resolveCallReturnClone($call);
            if ($returnCloneExpr !== null) {
                $args[] = new \ConfigTransformer202108166\PhpParser\Node\Arg($returnCloneExpr);
            }
            $currentArray = \current($call);
            if ($currentArray instanceof \ConfigTransformer202108166\Symfony\Component\Yaml\Tag\TaggedValue) {
                $args[] = new \ConfigTransformer202108166\PhpParser\Node\Arg(\ConfigTransformer202108166\PhpParser\BuilderHelpers::normalizeValue(\true));
            }
            $methodCall = new \ConfigTransformer202108166\PhpParser\Node\Expr\MethodCall($methodCall, 'call', $args);
        }
        return $methodCall;
    }
    private function resolveCallMethod($call) : \ConfigTransformer202108166\PhpParser\Node\Scalar\String_
    {
        return new \ConfigTransformer202108166\PhpParser\Node\Scalar\String_($call[0] ?? $call['method'] ?? \key($call));
    }
    private function resolveCallArguments($call) : \ConfigTransformer202108166\PhpParser\Node\Expr
    {
        $arguments = $call[1] ?? $call['arguments'] ?? \current($call);
        return $this->argsNodeFactory->resolveExpr($arguments);
    }
    private function resolveCallReturnClone(array $call) : ?\ConfigTransformer202108166\PhpParser\Node\Expr
    {
        if (isset($call[2]) || isset($call['returns_clone'])) {
            $returnsCloneValue = $call[2] ?? $call['returns_clone'];
            return \ConfigTransformer202108166\PhpParser\BuilderHelpers::normalizeValue($returnsCloneValue);
        }
        return null;
    }
}
