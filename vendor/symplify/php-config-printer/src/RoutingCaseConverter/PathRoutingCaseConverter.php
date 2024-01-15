<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformerPrefix202401\PhpParser\Node\Arg;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\Enum\RouteOption;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\Routing\ControllerSplitter;
use Symplify\PhpConfigPrinter\ValueObject\Routing\RouteDefaults;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class PathRoutingCaseConverter implements RoutingCaseConverterInterface
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Routing\ControllerSplitter
     */
    private $controllerSplitter;
    public function __construct(ArgsNodeFactory $argsNodeFactory, ControllerSplitter $controllerSplitter)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->controllerSplitter = $controllerSplitter;
    }
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool
    {
        return isset($values[RouteOption::PATH]);
    }
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : Stmt
    {
        $variable = new Variable(VariableName::ROUTING_CONFIGURATOR);
        $args = $this->createAddArgs($key, $values);
        $methodCall = new MethodCall($variable, 'add', $args);
        foreach (RouteOption::ALL as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $nestedValues = $values[$nestedKey];
            // Transform methods as string GET|HEAD to array
            if ($nestedKey === RouteOption::METHODS && \is_string($nestedValues)) {
                $nestedValues = \explode('|', $nestedValues);
            }
            // if default and controller, replace with controller() method
            // @see https://github.com/symfony/symfony/pull/24180/files#r141346267
            if ($this->controllerSplitter->hasControllerDefaults($nestedKey, $nestedValues)) {
                $controllerValue = $nestedValues[RouteDefaults::CONTROLLER];
                // split to class + method for better readability
                $controllerValue = $this->controllerSplitter->splitControllerClassAndMethod($controllerValue);
                $args = $this->argsNodeFactory->createFromValues([$controllerValue]);
                $methodCall = new MethodCall($methodCall, 'controller', $args);
                unset($nestedValues[RouteDefaults::CONTROLLER]);
            }
            if (!\is_array($nestedValues) || \is_array($nestedValues) && $nestedValues !== []) {
                $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
                $methodCall = new MethodCall($methodCall, $nestedKey, $args);
            }
        }
        return new Expression($methodCall);
    }
    /**
     * @return Arg[]
     * @param mixed $values
     */
    private function createAddArgs(string $key, $values) : array
    {
        $argumentValues = [];
        $argumentValues[] = $key;
        if (isset($values[RouteOption::PATH])) {
            $argumentValues[] = $values[RouteOption::PATH];
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
