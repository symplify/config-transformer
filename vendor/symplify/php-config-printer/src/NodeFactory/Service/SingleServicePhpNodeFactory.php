<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node\Arg;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202501\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202501\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
final class SingleServicePhpNodeFactory
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     * @param array<string, mixed> $properties
     */
    public function createProperties(MethodCall $methodCall, array $properties) : MethodCall
    {
        foreach ($properties as $name => $value) {
            $args = $this->argsNodeFactory->createFromValues([$name, $value]);
            $methodCall = new MethodCall($methodCall, 'property', $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $calls
     * @see https://symfony.com/doc/current/service_container/injection_types.html
     */
    public function createCalls(MethodCall $methodCall, array $calls) : MethodCall
    {
        foreach ($calls as $call) {
            $methodCall = $this->createCallMethodCall($call, $methodCall);
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallMethod(array $call) : String_
    {
        return new String_($call[0] ?? $call['method'] ?? \key($call));
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallArguments(array $call) : Expr
    {
        $arguments = $call[1] ?? $call['arguments'] ?? \current($call);
        return $this->argsNodeFactory->resolveExpr($arguments);
    }
    /**
     * @param mixed[] $call
     */
    private function resolveCallReturnClone(array $call) : ?Expr
    {
        if (isset($call[2]) || isset($call['returns_clone'])) {
            $returnsCloneValue = $call[2] ?? $call['returns_clone'];
            return BuilderHelpers::normalizeValue($returnsCloneValue);
        }
        return null;
    }
    /**
     * @param mixed $call
     */
    private function createCallMethodCall($call, MethodCall $methodCall) : MethodCall
    {
        $args = [];
        $string = $this->resolveCallMethod($call);
        $args[] = new Arg($string);
        $argumentsExpr = $this->resolveCallArguments($call);
        $args[] = new Arg($argumentsExpr);
        $returnCloneExpr = $this->resolveCallReturnClone($call);
        if ($returnCloneExpr instanceof Expr) {
            $args[] = new Arg($returnCloneExpr);
        }
        $currentArray = \current($call);
        if ($currentArray instanceof TaggedValue) {
            $args[] = new Arg(BuilderHelpers::normalizeValue(\true));
        }
        return new MethodCall($methodCall, 'call', $args);
    }
}
