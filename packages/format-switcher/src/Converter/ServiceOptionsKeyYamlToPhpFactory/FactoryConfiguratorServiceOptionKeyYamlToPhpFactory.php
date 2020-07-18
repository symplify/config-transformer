<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceOptionsKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use PhpParser\Node\Expr\MethodCall;

final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }

    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall): MethodCall
    {
        $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
        return new MethodCall($methodCall, 'factory', $args);
    }

    public function isMatch($key, $values): bool
    {
        return in_array($key, [YamlKey::FACTORY, YamlKey::CONFIGURATOR], true);
    }
}
