<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\Builder\Param;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;

final class PhpNodeFactory
{
    /**
     * @var string
     */
    private const CONTAINER_CONFIGURATOR_NAME = 'containerConfigurator';

    /**
     * @param Node[] $stmts
     */
    public function createClosureFromStmts(array $stmts): Closure
    {
        $paramBuilder = new Param(self::CONTAINER_CONFIGURATOR_NAME);
        $paramBuilder->setType('ContainerConfigurator');

        $param = $paramBuilder->getNode();

        return new Closure([
            'params' => [$param],
            'stmts' => $stmts,
            'static' => true,
        ]);
    }

    public function createAssignContainerCallToVariable(string $variableName, string $methodCallName): Assign
    {
        $variable = new Variable($variableName);
        $containerConfiguratorVariable = new Variable(self::CONTAINER_CONFIGURATOR_NAME);

        return new Assign($variable, new MethodCall($containerConfiguratorVariable, $methodCallName));
    }

    public function createParameterSetMethodCall(string $parameterName, $value): MethodCall
    {
        $parametersSetMethodCall = new MethodCall(new Variable('parameters'), 'set');
        $parametersSetMethodCall->args[] = new Arg(BuilderHelpers::normalizeValue($parameterName));

        $parameterValue = $this->createParamValue($value);
        $parametersSetMethodCall->args[] = new Arg($parameterValue);

        return $parametersSetMethodCall;
    }

    private function createParamValue($value): Expr
    {
        $parameterValue = BuilderHelpers::normalizeValue($value);
        if ($parameterValue instanceof Array_) {
            $parameterValue->setAttribute('kind', Array_::KIND_SHORT);
        }

        return $parameterValue;
    }
}
