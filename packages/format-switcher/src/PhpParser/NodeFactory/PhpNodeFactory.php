<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;

final class PhpNodeFactory
{
    public function createParameterSetMethodCall(string $parameterName, $value): Expression
    {
        $methodCall = new MethodCall(new Variable(VariableName::PARAMETERS), 'set');
        $methodCall->args[] = new Arg(BuilderHelpers::normalizeValue($parameterName));

        $parameterValue = $this->createParamValue($value);
        $methodCall->args[] = new Arg($parameterValue);

        return new Expression($methodCall);
    }

    /**
     * @param mixed[] $arguments
     */
    public function createImportMethodCall(array $arguments): Expression
    {
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import');

        foreach ($arguments as $argument) {
            $expr = $this->createAbsoluteDirExpr($argument);
            $methodCall->args[] = new Arg($expr);
        }

        return new Expression($methodCall);
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
        return BuilderHelpers::normalizeValue($value);
    }
}
