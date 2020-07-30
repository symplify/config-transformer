<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceOptionsKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlServiceKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Sorter\YamlArgumentSorter;
use PhpParser\Node\Expr\MethodCall;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class DecoratesServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
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
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(
        ArgsNodeFactory $argsNodeFactory,
        YamlArgumentSorter $yamlArgumentSorter,
        CommonNodeFactory $commonNodeFactory
    ) {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall): MethodCall
    {
        $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [
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

        array_unshift($arguments, $values['decorates']);

        $args = $this->argsNodeFactory->createFromValues($arguments);
        return new MethodCall($methodCall, 'decorate', $args);
    }

    public function isMatch($key, $values): bool
    {
        return $key === YamlServiceKey::DECORATES;
    }
}
