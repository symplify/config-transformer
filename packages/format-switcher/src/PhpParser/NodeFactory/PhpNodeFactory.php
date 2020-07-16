<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

final class PhpNodeFactory
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }

    public function createParameterSetMethodCall(string $parameterName, $value): Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$parameterName, $value]);

        $parametersVariable = new Variable(VariableName::PARAMETERS);
        $methodCall = new MethodCall($parametersVariable, 'set', $args);
        return new Expression($methodCall);
    }
}
