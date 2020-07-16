<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Sorter\YamlArgumentSorter;
use Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ServiceOptionNodeFactory
{
    /**
     * @var string
     */
    private const CONFIGURATOR = 'configurator';

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
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;

    public function __construct(
        CommonNodeFactory $commonNodeFactory,
        YamlArgumentSorter $yamlArgumentSorter,
        ArgsNodeFactory $argsNodeFactory,
        SingleServicePhpNodeFactory $singleServicePhpNodeFactory
    ) {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }

    public function convertServiceOptionsToNodes(array $servicesValues, MethodCall $methodCall): MethodCall
    {
        if ($this->isNestedArguments($servicesValues)) {
            $servicesValues = [
                'arguments' => $servicesValues,
            ];
        }

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

                case YamlKey::FACTORY:
                case self::CONFIGURATOR:
                    $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($value);
                    $methodCall = new MethodCall($methodCall, 'factory', $args);
                    break;

                case YamlKey::TAGS:
                    $methodCall = $this->processTagsKey($value, $methodCall);
                    break;

                case YamlKey::CALLS:
                    $methodCall = $this->singleServicePhpNodeFactory->createCalls($methodCall, $value);
                    break;

                case YamlKey::PROPERTIES:
                    $methodCall = $this->singleServicePhpNodeFactory->createProperties($methodCall, $value);
                    break;

                case YamlKey::ARGUMENTS:
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

    private function isNestedArguments(array $servicesValues): bool
    {
        if (count($servicesValues) === 0) {
            return false;
        }

        foreach (array_keys($servicesValues) as $key) {
            if (! Strings::startsWith((string) $key, '$')) {
                return false;
            }
        }

        return true;
    }

    private function processTagsKey($value, MethodCall $methodCall): MethodCall
    {
        /** @var mixed[] $value */
        if (count($value) === 1 && is_string($value[0])) {
            $tagValue = new String_($value[0]);
            return new MethodCall($methodCall, 'tag', [new Arg($tagValue)]);
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

        return $methodCall;
    }
}
