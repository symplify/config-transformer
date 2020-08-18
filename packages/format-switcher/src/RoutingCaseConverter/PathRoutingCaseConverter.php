<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\RoutingCaseConverter;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\RoutingCaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

final class PathRoutingCaseConverter implements RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['controller', 'defaults'];

    /**
     * @var string
     */
    private const PATH = 'path';

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }

    public function match(string $key, $values): bool
    {
        return isset($values[self::PATH]);
    }

    public function convertToMethodCall(string $key, $values): Expression
    {
        $variable = new Variable(VariableName::ROUTING_CONFIGURATOR);

        // @todo args

        $args = $this->createAddArgs($key, $values);
        $methodCall = new MethodCall($variable, 'add', $args);

        foreach (self::NESTED_KEYS as $nestedKey) {
            if (! isset($values[$nestedKey])) {
                continue;
            }

            $args = $this->argsNodeFactory->createFromValues([$values[$nestedKey]]);
            $methodCall = new MethodCall($methodCall, $nestedKey, $args);
        }

        return new Expression($methodCall);
    }

    /**
     * @param mixed $values
     * @return Arg[]
     */
    private function createAddArgs(string $key, $values): array
    {
        $argumentValues = [];
        $argumentValues[] = $key;

        if (isset($values[self::PATH])) {
            $argumentValues[] = $values[self::PATH];
        }

        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
