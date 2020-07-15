<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServicesPhpNodeFactory;

/**
 * Handles this part:
 *
 * services:
 *     App\\: <--
 *          source: '../src'
 */
final class ResourceServiceKeyYamlToPhpFactory implements ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    public function __construct(ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }

    public function convertYamlToNodes($serviceKey, $serviceValues): array
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($serviceValues['namespace'])) {
            $serviceKey = $serviceValues['namespace'];
            unset($serviceValues['namespace']);
        }

        $resource = $this->servicesPhpNodeFactory->createResource($serviceKey, $serviceValues);
        return [$resource];
    }

    public function isMatch($key, $values): bool
    {
        return isset($values[YamlKey::RESOURCE]);
    }
}
