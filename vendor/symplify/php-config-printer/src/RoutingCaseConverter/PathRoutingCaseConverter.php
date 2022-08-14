<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer202208\PhpParser\Node\Arg;
use ConfigTransformer202208\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202208\PhpParser\Node\Expr\Variable;
use ConfigTransformer202208\PhpParser\Node\Stmt;
use ConfigTransformer202208\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\Enum\RouteOption;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class PathRoutingCaseConverter implements RoutingCaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
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
            if ($this->hasControllerDefaults($nestedKey, $nestedValues)) {
                $controllerValue = $nestedValues['_controller'];
                $args = $this->argsNodeFactory->createFromValues([$controllerValue]);
                $methodCall = new MethodCall($methodCall, 'controller', $args);
                unset($nestedValues['_controller']);
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
    /**
     * @param mixed $nestedValues
     */
    private function hasControllerDefaults(string $nestedKey, $nestedValues) : bool
    {
        if ($nestedKey !== RouteOption::DEFAULTS) {
            return \false;
        }
        return \array_key_exists('_controller', $nestedValues);
    }
}
