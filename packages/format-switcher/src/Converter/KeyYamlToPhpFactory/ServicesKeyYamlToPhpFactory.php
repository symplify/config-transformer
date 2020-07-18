<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ManyConfigurationInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServicesPhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
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
     * @var YamlCommentPreserver
     */
    private $yamlCommentPreserver;

    /**
     * @param ServiceKeyYamlToPhpFactoryInterface[] $serviceKeyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        YamlCommentPreserver $yamlCommentPreserver,
        array $serviceKeyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->serviceKeyYamlToPhpFactories = $serviceKeyYamlToPhpFactories;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
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

            if ($this->yamlCommentPreserver->isCommentKey($serviceKey)) {
                $this->yamlCommentPreserver->collectComment($serviceValues);
                unset($yaml[$serviceKey]);
                continue;
            }

            foreach ($this->serviceKeyYamlToPhpFactories as $serviceKeyYamlToPhpFactory) {
                if (! $serviceKeyYamlToPhpFactory->isMatch($serviceKey, $serviceValues)) {
                    continue;
                }

                if ($serviceKeyYamlToPhpFactory instanceof ManyConfigurationInterface) {
                    foreach ($serviceValues as $subServiceKey => $subServiceValues) {
                        if ($this->yamlCommentPreserver->isCommentKey($subServiceKey)) {
                            $this->yamlCommentPreserver->collectComment($subServiceValues);
                            unset($serviceValues[$subServiceKey]);
                            continue;
                        }

                        $nodes[] = $this->processNode($serviceKeyYamlToPhpFactory, $subServiceKey, $subServiceValues);
                    }

                    continue 2;
                }

                if (is_array($serviceValues)) {
                    $serviceValues = $this->yamlCommentPreserver->collectCommentsFromArray($serviceValues);
                }

                $nodes[] = $this->processNode($serviceKeyYamlToPhpFactory, $serviceKey, $serviceValues);
                continue 2;
            }
        }

        return $nodes;
    }

    private function processNode(
        ServiceKeyYamlToPhpFactoryInterface $serviceKeyYamlToPhpFactory,
        $subserviceKey,
        $subserviceValues
    ) {
        $node = $serviceKeyYamlToPhpFactory->convertYamlToNode($subserviceKey, $subserviceValues);
        $this->yamlCommentPreserver->decorateNodeWithComments($node);

        return $node;
    }
}
