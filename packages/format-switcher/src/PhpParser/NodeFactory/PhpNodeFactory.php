<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
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

    private function createParamValue($value): Expr
    {
        return BuilderHelpers::normalizeValue($value);
    }
}
