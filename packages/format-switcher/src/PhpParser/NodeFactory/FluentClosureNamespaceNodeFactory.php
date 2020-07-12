<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class FluentClosureNamespaceNodeFactory
{
    /**
     * @var string
     */
    private const DECORATION_ON_INVALID = 'decoration_on_invalid';

    /**
     * @var string
     */
    private const DECORATION_INNER_NAME = 'decoration_inner_name';

    /**
     * @var string
     */
    private const DECORATION_PRIORITY = 'decoration_priority';

    /**
     * @var string
     */
    private const ARGUMENTS = 'arguments';

    /**
     * @var string
     */
    private const CALLS = 'calls';

    /**
     * @var string
     */
    private const TAGS = 'tags';

    /**
     * @var string
     */
    private const CONFIGURATOR = 'configurator';

    /**
     * @var string
     */
    private const FACTORY = 'factory';

    /**
     * @var string
     */
    private const DEFAULTS = '_defaults';

    /**
     * @var string
     */
    private const INSTANCE_OF = '_instanceof';

    /**
     * @var string
     */
    private const RESOURCE = 'resource';

    /**
     * @var string
     */
    private const CLASS_KEY = 'class';

    /**
     * @var string
     */
    private const ALIAS = 'alias';

    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    /**
     * @var ClosureNodeFactory
     */
    private $closureNodeFactory;

    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;

    /**
     * @var ImportNodeFactory
     */
    private $importNodeFactory;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var KeyYamlToPhpFactoryInterface[]
     */
    private $keyYamlToPhpFactories = [];

    /**
     * @param KeyYamlToPhpFactoryInterface[] $keyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        ClosureNodeFactory $closureNodeFactory,
        SingleServicePhpNodeFactory $singleServicePhpNodeFactory,
        ImportNodeFactory $importNodeFactory,
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        array $keyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->closureNodeFactory = $closureNodeFactory;
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
        $this->importNodeFactory = $importNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->keyYamlToPhpFactories = $keyYamlToPhpFactories;
    }

    public function createFromYamlArray(array $yamlArray): Namespace_
    {
        $closureStmts = $this->createClosureStmts($yamlArray);
        $closure = $this->closureNodeFactory->createClosureFromStmts($closureStmts);

        $namespace = $this->createNamespace();
        $namespace->stmts[] = new Return_($closure);

        return $namespace;
    }

    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData): array
    {
        $nodes = [];

        foreach ($yamlData as $key => $values) {
            // normalize values
            if ($values === null) {
                // declare the variable ($parameters/$services) even if the key is written without values.
                $values = [];
            }

            foreach ($this->keyYamlToPhpFactories as $keyYamlToPhpFactory) {
                if ($keyYamlToPhpFactory->getKey() !== $key) {
                    continue;
                }

                $freshNodes = $keyYamlToPhpFactory->convertYamlToNodes($values);
                $nodes = array_merge($nodes, $freshNodes);
                continue 2;
            }

            switch ($key) {
                case 'imports':
                    $importNodes = $this->addImportsNodes($values);
                    $nodes = array_merge($nodes, $importNodes);
                    break;

                case 'services':
                    $serviceNodes = $this->addServicesNodes($values);
                    $nodes = array_merge($nodes, $serviceNodes);
                    break;
                default:
                    throw new ShouldNotHappenException(sprintf(
                        'The key %s is not supported by the converter: only service config can live in services.yaml for conversion.',
                        $key
                    ));
            }
        }

        return $nodes;
    }

    /**
     * @return Node[]
     */
    private function addImportsNodes(array $imports): array
    {
        $nodes = [];

        foreach ($imports as $import) {
            if (is_array($import)) {
                $arguments = $this->sortArgumentsByKeyIfExists($import, [self::RESOURCE, 'type', 'ignore_errors']);

                $nodes[] = $this->importNodeFactory->createImportMethodCall($arguments);
                continue;
            }

            throw new NotImplementedYetException();
        }

        return $nodes;
    }

    /**
     * @return Node[]
     */
    private function addServicesNodes(array $services): array
    {
        $nodes = [];
        $nodes[] = $this->servicesPhpNodeFactory->createServicesInit();

        foreach ($services as $serviceKey => $serviceValues) {
            if ($serviceKey === self::DEFAULTS) {
                $nodes[] = $this->servicesPhpNodeFactory->createServiceDefaults($serviceValues);
                continue;
            }

            if ($serviceKey === self::INSTANCE_OF) {
                $instanceOfNodes = $this->resolveInstanceOf($serviceValues);
                $nodes = array_merge($nodes, $instanceOfNodes);
                continue;
            }

            if (isset($serviceValues[self::RESOURCE])) {
                $resourceNodes = $this->resolveResource($serviceKey, $serviceValues);
                $nodes = array_merge($nodes, $resourceNodes);
                continue;
            }

            if ($this->isAlias($serviceKey, $serviceValues)) {
                $aliasNodes = $this->addAliasNode($serviceKey, $serviceValues);
                $nodes = array_merge($nodes, $aliasNodes);
                continue;
            }

            if (isset($serviceValues[self::CLASS_KEY])) {
                $serviceNodes = $this->createService($serviceValues, $serviceKey);
                $nodes = array_merge($nodes, $serviceNodes);
                continue;
            }

            if ($serviceValues === null) {
                $setMethodCall = $this->singleServicePhpNodeFactory->createSetService($serviceKey);
            } else {
                $args = $this->argsNodeFactory->createFromValues([$serviceKey]);
                $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', $args);

                $setMethodCall = $this->convertServiceOptionsToNodes($serviceValues, $setMethodCall);
            }

            $nodes[] = new Expression($setMethodCall);
        }

        return $nodes;
    }

    private function convertServiceOptionsToNodes(array $servicesValues, MethodCall $methodCall): MethodCall
    {
        foreach ($servicesValues as $serviceConfigKey => $value) {
            // options started by decoration_<option> are used as options of the method decorate().
            if (strstr($serviceConfigKey, 'decoration_')) {
                continue;
            }

            switch ($serviceConfigKey) {
                case 'decorates':
                    $methodCall = $this->createDecorateMethod($servicesValues, $methodCall);
                    break;

                case 'deprecated':
                    $methodCall = $this->createDeprecateMethod($value, $methodCall);
                    break;

                // simple "key: value" options
                case 'shared':
                case 'public':
                    if ($serviceConfigKey === 'public') {
                        if ($value === false) {
                            $methodCall = new MethodCall($methodCall, 'private');
                        } else {
                            $methodCall = new MethodCall($methodCall, 'public');
                        }
                        break;
                    }

                    throw new NotImplementedYetException();

                case 'bind':
                case 'autowire':
                case 'autoconfigure':
                    $method = $serviceConfigKey;
                    if ($serviceConfigKey === 'shared') {
                        $method = 'share';
                    }

                    $methodCall = new MethodCall($methodCall, $method);
                    if ($value === false) {
                        $methodCall->args[] = new Arg($this->commonNodeFactory->createFalse());
                    }

                    break;

                case self::FACTORY:
                case self::CONFIGURATOR:
                    $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($value);
                    $methodCall = new MethodCall($methodCall, 'factory', $args);
                    break;

                case self::TAGS:
                    /** @var mixed[] $value */
                    if (count($value) === 1 && is_string($value[0])) {
                        $tagValue = new String_($value[0]);
                        $methodCall = new MethodCall($methodCall, 'tag', [new Arg($tagValue)]);
                        break;
                    }

                    foreach ($value as $singleValue) {
                        $args = [];
                        foreach ($singleValue as $singleNestedKey => $singleNestedValue) {
                            if ($singleNestedKey === 'name') {
                                $args[] = new Arg(BuilderHelpers::normalizeValue($singleNestedValue));
                                unset($singleValue[$singleNestedKey]);
                            }
                        }

                        $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($singleValue);

                        $args = array_merge($args, $restArgs);
                        $methodCall = new MethodCall($methodCall, 'tag', $args);
                    }

                    break;

                case self::CALLS:
                    $methodCall = $this->singleServicePhpNodeFactory->createCalls($methodCall, $value);
                    break;

                case self::ARGUMENTS:
                    $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($value);
                    $methodCall = new MethodCall($methodCall, 'args', $args);

                    break;

                default:
                    throw new ShouldNotHappenException(sprintf(
                        'Unexpected service configuration option: "%s".',
                        $serviceConfigKey
                    ));
            }
        }

        return $methodCall;
    }

    /**
     * @return Node[]
     */
    private function addAliasNode($serviceKey, $serviceValues): array
    {
        $nodes = [];

        $servicesVariable = new Variable('services');

        if (class_exists($serviceKey) || interface_exists($serviceKey)) {
            // $this->addUseStatementIfNecessary($serviceValues[self::ALIAS]); - @todo import alias

            $classReference = $this->commonNodeFactory->createClassReference($serviceKey);

            $values = [$classReference];
            $values[] = $serviceValues[self::ALIAS] ?? $serviceValues;

            $args = $this->argsNodeFactory->createFromValues($values, true);

            $methodCall = new MethodCall($servicesVariable, 'alias', $args);
            return [new Expression($methodCall)];
        }

        if ($fullClassName = strstr($serviceKey, ' $', true)) {
            $methodCall = $this->createAliasNode($serviceKey, $fullClassName, $serviceValues);
            return [new Expression($methodCall)];
        }

        if (isset($serviceValues[self::ALIAS])) {
            $className = $serviceValues[self::ALIAS];

            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$serviceKey, $classReference]);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
            unset($serviceValues[self::ALIAS]);
        }

        if (is_string($serviceValues) && $serviceValues[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$serviceValues], true);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
        }

        if (is_array($serviceValues)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->convertServiceOptionsToNodes($serviceValues, $methodCall);
        }

        $nodes[] = new Expression($methodCall);

        return $nodes;
    }

    private function createDecorateMethod(array $value, MethodCall $methodCall): MethodCall
    {
        $arguments = $this->sortArgumentsByKeyIfExists($value, [
            self::DECORATION_INNER_NAME => null,
            self::DECORATION_PRIORITY => 0,
            self::DECORATION_ON_INVALID => null,
        ]);

        if (isset($arguments[self::DECORATION_ON_INVALID])) {
            $arguments[self::DECORATION_ON_INVALID] = $arguments[self::DECORATION_ON_INVALID] === 'exception'
                ? $this->commonNodeFactory->createConstFetch(
                    ContainerInterface::class,
                    'EXCEPTION_ON_INVALID_REFERENCE'
                )
                : $this->commonNodeFactory->createConstFetch(
                    ContainerInterface::class,
                    'IGNORE_ON_INVALID_REFERENCE'
                );
        }

        // Don't write the next arguments if they are null.
        if ($arguments[self::DECORATION_ON_INVALID] === null && $arguments[self::DECORATION_PRIORITY] === 0) {
            unset($arguments[self::DECORATION_ON_INVALID], $arguments[self::DECORATION_PRIORITY]);

            if ($arguments[self::DECORATION_INNER_NAME] === null) {
                unset($arguments[self::DECORATION_INNER_NAME]);
            }
        }

        array_unshift($arguments, $value['decorates']);

        $args = [];
        foreach ($arguments as $argument) {
            // is class const refrence
            $value = BuilderHelpers::normalizeValue($argument);
            $args[] = new Arg($value);
        }

        return new MethodCall($methodCall, 'decorate', $args);
    }

    private function createDeprecateMethod($value, MethodCall $methodCall): MethodCall
    {
        // the old, simple format
        if (! is_array($value)) {
            $args = $this->argsNodeFactory->createFromValues([$value]);
        } else {
            $items = [$value['package'] ?? '', $value['version'] ?? '', $value['message'] ?? ''];

            $args = $this->argsNodeFactory->createFromValues($items);
        }

        return new MethodCall($methodCall, 'deprecate', $args);
    }

    /**
     * @param array $inOrderKeys Pass an array of keys to sort if exists
     *                           or an associative array following this logic [$key => $valueIfNotExists]
     *
     * @return array
     */
    private function sortArgumentsByKeyIfExists(array $arrayToSort, array $inOrderKeys)
    {
        $argumentsInOrder = [];

        if ($this->isAssociativeArray($inOrderKeys)) {
            foreach ($inOrderKeys as $key => $valueIfNotExists) {
                $argumentsInOrder[$key] = $arrayToSort[$key] ?? $valueIfNotExists;
            }

            return $argumentsInOrder;
        }

        foreach ($inOrderKeys as $key) {
            if (isset($arrayToSort[$key])) {
                $argumentsInOrder[] = $arrayToSort[$key];
            }
        }

        return $argumentsInOrder;
    }

    private function isAlias(string $serviceKey, $serviceValues): bool
    {
        return isset($serviceValues[self::ALIAS])
            || strstr($serviceKey, ' $', true)
            || is_string($serviceValues) && $serviceValues[0] === '@';
    }

    private function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @return Node[]
     */
    private function createService(array $serviceValues, string $serviceKey): array
    {
        $nodes = [];

        $args = $this->argsNodeFactory->createFromValues([$serviceKey, $serviceValues[self::CLASS_KEY]]);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', $args);

        unset($serviceValues[self::CLASS_KEY]);

        $setMethodCall = $this->convertServiceOptionsToNodes($serviceValues, $setMethodCall);
        $nodes[] = new Expression($setMethodCall);

        return $nodes;
    }

    private function createAliasNode($serviceKey, string $fullClassName, $serviceValues): MethodCall
    {
        $argument = strstr($serviceKey, '$');

        $methodCall = new MethodCall(new Variable(VariableName::SERVICES), self::ALIAS);

        $classConstReference = $this->commonNodeFactory->createClassReference($fullClassName);
        $concat = new Concat($classConstReference, new String_(' ' . $argument));

        $methodCall->args[] = new Arg($concat);

        $serviceName = ltrim($serviceValues, '@');
        $methodCall->args[] = new Arg(new String_($serviceName));

        return $methodCall;
    }

    /**
     * @return Node[]
     */
    private function resolveInstanceOf($serviceValues): array
    {
        $nodes = [];
        foreach ($serviceValues as $instanceKey => $instanceValues) {
            $classReference = $this->commonNodeFactory->createClassReference($instanceKey);

            $servicesVariable = new Variable(VariableName::SERVICES);
            $args = [new Arg($classReference)];

            $instanceofMethodCall = new MethodCall($servicesVariable, 'instanceof', $args);
            $instanceofMethodCall = $this->convertServiceOptionsToNodes($instanceValues, $instanceofMethodCall);

            $nodes[] = new Expression($instanceofMethodCall);
        }

        return $nodes;
    }

    /**
     * @return Node[]
     */
    private function resolveResource($serviceKey, $serviceValues): array
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($serviceValues['namespace'])) {
            $serviceKey = $serviceValues['namespace'];
            unset($serviceValues['namespace']);
        }

        $resource = $this->servicesPhpNodeFactory->createResource($serviceKey, $serviceValues);
        return [$resource];
    }

    private function createNamespace(): Namespace_
    {
        $namespaceName = new Name('Symfony\Component\DependencyInjection\Loader\Configurator');
        return new Namespace_($namespaceName);
    }
}
