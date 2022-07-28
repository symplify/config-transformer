<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer202207\PhpParser\Node\Arg;
use ConfigTransformer202207\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202207\PhpParser\Node\Expr\Variable;
use ConfigTransformer202207\PhpParser\Node\Stmt;
use ConfigTransformer202207\PhpParser\Node\Stmt\Expression;
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
        // @todo args
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
            $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
            $methodCall = new MethodCall($methodCall, $nestedKey, $args);
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
