<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlServiceKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
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
        $servicesValues = $this->unnestArguments($servicesValues);

        foreach ($servicesValues as $key => $value) {
            // options started by decoration_<option> are used as options of the method decorate().
            if (Strings::startsWith($key, 'decoration_')) {
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

            $message = sprintf('Unexpected service configuration option "%s".', $key);
            throw new ShouldNotHappenException($message);
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

    private function unnestArguments(array $servicesValues): array
    {
        if ($this->isNestedArguments($servicesValues)) {
            $servicesValues = [
                YamlServiceKey::ARGUMENTS => $servicesValues,
            ];
        }
        return $servicesValues;
    }
}
