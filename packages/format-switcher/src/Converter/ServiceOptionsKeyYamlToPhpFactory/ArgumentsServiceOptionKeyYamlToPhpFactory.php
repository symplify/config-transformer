<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceOptionsKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlServiceKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;

final class ArgumentsServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
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
        if (! $this->hasNamedArguments($yaml)) {
            $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
            return new MethodCall($methodCall, 'args', $args);
        }

        foreach ($yaml as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new MethodCall($methodCall, 'arg', $args);
        }

        return $methodCall;
    }

    public function isMatch($key, $values): bool
    {
        return $key === YamlServiceKey::ARGUMENTS;
    }

    private function hasNamedArguments(array $data): bool
    {
        if (count($data) === 0) {
            return false;
        }

        foreach (array_keys($data) as $key) {
            if (! Strings::startsWith((string) $key, '$')) {
                return false;
            }
        }

        return true;
    }
}
