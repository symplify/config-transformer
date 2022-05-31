<?php

declare (strict_types=1);
namespace ConfigTransformer202205313\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202205313\PhpParser\BuilderHelpers;
use ConfigTransformer202205313\PhpParser\Node\Arg;
use ConfigTransformer202205313\PhpParser\Node\Expr;
use ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205313\PhpParser\Node\Scalar\String_;
use ConfigTransformer202205313\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer202205313\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
final class SingleServicePhpNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202205313\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     * @param array<string, mixed> $properties
     */
    public function createProperties(\ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall $methodCall, array $properties) : \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall
    {
        foreach ($properties as $name => $value) {
            $args = $this->argsNodeFactory->createFromValues([$name, $value]);
            $methodCall = new \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall($methodCall, 'property', $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $calls
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createCalls(\ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall $methodCall, array $calls) : \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall
    {
        foreach ($calls as $call) {
            $methodCall = $this->createCallMethodCall($call, $methodCall);
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallMethod(array $call) : \ConfigTransformer202205313\PhpParser\Node\Scalar\String_
    {
        return new \ConfigTransformer202205313\PhpParser\Node\Scalar\String_($call[0] ?? $call['method'] ?? \key($call));
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallArguments(array $call) : \ConfigTransformer202205313\PhpParser\Node\Expr
    {
        $arguments = $call[1] ?? $call['arguments'] ?? \current($call);
        return $this->argsNodeFactory->resolveExpr($arguments);
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallReturnClone(array $call) : ?\ConfigTransformer202205313\PhpParser\Node\Expr
    {
        if (isset($call[2]) || isset($call['returns_clone'])) {
            $returnsCloneValue = $call[2] ?? $call['returns_clone'];
            return \ConfigTransformer202205313\PhpParser\BuilderHelpers::normalizeValue($returnsCloneValue);
        }
        return null;
    }
    /**
     * @param mixed $call
     */
    private function createCallMethodCall($call, \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall
    {
        $args = [];
        $string = $this->resolveCallMethod($call);
        $args[] = new \ConfigTransformer202205313\PhpParser\Node\Arg($string);
        $argumentsExpr = $this->resolveCallArguments($call);
        $args[] = new \ConfigTransformer202205313\PhpParser\Node\Arg($argumentsExpr);
        $returnCloneExpr = $this->resolveCallReturnClone($call);
        if ($returnCloneExpr !== null) {
            $args[] = new \ConfigTransformer202205313\PhpParser\Node\Arg($returnCloneExpr);
        }
        $currentArray = \current($call);
        if ($currentArray instanceof \ConfigTransformer202205313\Symfony\Component\Yaml\Tag\TaggedValue) {
            $args[] = new \ConfigTransformer202205313\PhpParser\Node\Arg(\ConfigTransformer202205313\PhpParser\BuilderHelpers::normalizeValue(\true));
        }
        return new \ConfigTransformer202205313\PhpParser\Node\Expr\MethodCall($methodCall, 'call', $args);
    }
}
