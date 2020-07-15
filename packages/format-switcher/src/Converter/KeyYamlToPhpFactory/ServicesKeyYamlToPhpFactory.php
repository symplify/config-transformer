<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServicesPhpNodeFactory;
use PhpParser\Node;

/**
 * Handles this part:
 *
 * services: <---
 */
final class ServicesKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const SERVICES = 'services';

    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    /**
     * @var ServiceKeyYamlToPhpFactoryInterface[]
     */
    private $serviceKeyYamlToPhpFactories = [];

    /**
     * @param ServiceKeyYamlToPhpFactoryInterface[] $serviceKeyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        array $serviceKeyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->serviceKeyYamlToPhpFactories = $serviceKeyYamlToPhpFactories;
    }

    public function getKey(): string
    {
        return self::SERVICES;
    }

    /**
     * @return Node[]
     */
    public function convertYamlToNodes(array $yaml): array
    {
        if (count($yaml) === 0) {
            return [];
        }

        $nodes = [];
        $nodes[] = $this->servicesPhpNodeFactory->createServicesInit();

        foreach ($yaml as $serviceKey => $serviceValues) {
            $serviceValues = $serviceValues ?? [];

            foreach ($this->serviceKeyYamlToPhpFactories as $serviceKeyYamlToPhpFactory) {
                if (! $serviceKeyYamlToPhpFactory->isMatch($serviceKey, $serviceValues)) {
                    continue;
                }

                $freshNodes = $serviceKeyYamlToPhpFactory->convertYamlToNodes($serviceKey, $serviceValues);
                $nodes = array_merge($nodes, $freshNodes);
                continue 2;
            }
        }

        return $nodes;
    }
}
