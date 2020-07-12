<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ServicesPhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\SingleServicePhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Sorter\YamlArgumentSorter;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ServicesKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
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
     * @var string
     */
    private const SERVICES = 'services';

    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;

    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;

    /**
     * @var ServiceKeyYamlToPhpFactoryInterface[]
     */
    private $serviceKeyYamlToPhpFactories = [];

    /**
     * @param ServiceKeyYamlToPhpFactoryInterface[] $serviceKeyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        YamlArgumentSorter $yamlArgumentSorter,
        SingleServicePhpNodeFactory $singleServicePhpNodeFactory,
        array $serviceKeyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
        $this->serviceKeyYamlToPhpFactories = $serviceKeyYamlToPhpFactories;
    }

    public function getKey(): string
    {
        return self::SERVICES;
    }

    /**
     * @return Node[]
     */
    public function convertYamlToNodes(array $services): array
    {
        $nodes = [];
        $nodes[] = $this->servicesPhpNodeFactory->createServicesInit();

        foreach ($services as $serviceKey => $serviceValues) {
            foreach ($this->serviceKeyYamlToPhpFactories as $serviceKeyYamlToPhpFactory) {
                if ($serviceKeyYamlToPhpFactory->getSubServiceKey() === $serviceKey) {
                    $freshNodes = $serviceKeyYamlToPhpFactory->convertYamlToNodes($serviceValues);
                    $nodes = array_merge($nodes, $freshNodes);
                    continue 2;
                }
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
        $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($value, [
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

    private function isAlias(string $serviceKey, $serviceValues): bool
    {
        return isset($serviceValues[self::ALIAS])
            || strstr($serviceKey, ' $', true)
            || is_string($serviceValues) && $serviceValues[0] === '@';
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
}
