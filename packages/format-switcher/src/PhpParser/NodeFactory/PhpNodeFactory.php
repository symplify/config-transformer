<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\Builder\Param;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;

final class PhpNodeFactory
{
    /**
     * @var string
     */
    private const CONTAINER_CONFIGURATOR_NAME = 'containerConfigurator';

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

    /**
     * @param mixed[] $arguments
     */
    public function createImportMethodCall(array $arguments): MethodCall
    {
        $containerConfiguratorVariable = new Variable(self::CONTAINER_CONFIGURATOR_NAME);
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import');

        foreach ($arguments as $argument) {
            $expr = $this->createAbsoluteDirExpr($argument);
            $methodCall->args[] = new Arg($expr);
        }

        return $methodCall;
    }

    public function createAbsoluteDirExpr($argument): Expr
    {
        if (is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }

        $argumentValue = BuilderHelpers::normalizeValue($argument);

        if ($argumentValue instanceof String_) {
            $argumentValue = new Concat(new Dir(), $argumentValue);
        }

        return $argumentValue;
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
