<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\CaseConverter;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     Some: Other <---
 */
final class AliasCaseConverter implements CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    public function __construct(
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        ServiceOptionNodeFactory $serviceOptionNodeFactory
    ) {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }

    public function convertToMethodCall(string $key, $values): Expression
    {
        $servicesVariable = new Variable(VariableName::SERVICES);

        if (class_exists($key) || interface_exists($key)) {
            // $this->addUseStatementIfNecessary($values[self::ALIAS]); - @todo import alias

            $classReference = $this->commonNodeFactory->createClassReference($key);

            $argValues = [];
            $argValues[] = $classReference;
            $argValues[] = $values[MethodName::ALIAS] ?? $values;

            $args = $this->argsNodeFactory->createFromValues($argValues, true);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);
            return new Expression($methodCall);
        }

        // handles: "SomeClass $someVariable: ..."
        if ($fullClassName = strstr($key, ' $', true)) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $values);
            return new Expression($methodCall);
        }

        if (isset($values[MethodName::ALIAS])) {
            $className = $values[MethodName::ALIAS];

            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);

            unset($values[MethodName::ALIAS]);
        }

        /** @var string|mixed[] $values */
        if (is_string($values) && $values[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$values], true);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);
        } elseif (is_array($values)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        }

        return new Expression($methodCall);
    }

    public function match(string $rootKey, $key, $values): bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return false;
        }

        if (isset($values[YamlKey::ALIAS])) {
            return true;
        }

        if (strstr($key, ' $', true)) {
            return true;
        }

        return is_string($values) && $values[0] === '@';
    }

    private function createAliasNode(string $key, string $fullClassName, $serviceValues): MethodCall
    {
        $args = [];

        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        $argumentName = strstr($key, '$');
        $concat = new Concat($classConstFetch, new String_(' ' . $argumentName));
        $args[] = new Arg($concat);

        $serviceName = ltrim($serviceValues, '@');
        $args[] = new Arg(new String_($serviceName));

        return new MethodCall(new Variable(VariableName::SERVICES), MethodName::ALIAS, $args);
    }
}
