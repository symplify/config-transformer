<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlServiceKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;

final class ServiceOptionNodeFactory
{
    /**
     * @var ServiceOptionsKeyYamlToPhpFactoryInterface[]
     */
    private $serviceOptionKeyYamlToPhpFactories = [];

    /**
     * @param ServiceOptionsKeyYamlToPhpFactoryInterface[] $serviceOptionKeyYamlToPhpFactories
     */
    public function __construct(array $serviceOptionKeyYamlToPhpFactories)
    {
        $this->serviceOptionKeyYamlToPhpFactories = $serviceOptionKeyYamlToPhpFactories;
    }

    public function convertServiceOptionsToNodes(array $servicesValues, MethodCall $methodCall): MethodCall
    {
        $servicesValues = $this->unNestArguments($servicesValues);

        foreach ($servicesValues as $key => $value) {
            // options started by decoration_<option> are used as options of the method decorate().
            if (Strings::startsWith($key, 'decoration_') || $key === 'alias') {
                continue;
            }

            foreach ($this->serviceOptionKeyYamlToPhpFactories as $serviceOptionKeyYamlToPhpFactory) {
                if (! $serviceOptionKeyYamlToPhpFactory->isMatch($key, $value)) {
                    continue;
                }

                $methodCall = $serviceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(
                    $key,
                    $value,
                    $servicesValues,
                    $methodCall
                );

                continue 2;
            }
        }

        return $methodCall;
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

    private function unNestArguments(array $servicesValues): array
    {
        if (! $this->isNestedArguments($servicesValues)) {
            return $servicesValues;
        }

        return [
            YamlServiceKey::ARGUMENTS => $servicesValues,
        ];
    }
}
