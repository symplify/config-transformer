<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ServicesPhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\SingleServicePhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

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
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;

    /**
     * @var ServiceKeyYamlToPhpFactoryInterface[]
     */
    private $serviceKeyYamlToPhpFactories = [];

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    /**
     * @param ServiceKeyYamlToPhpFactoryInterface[] $serviceKeyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        SingleServicePhpNodeFactory $singleServicePhpNodeFactory,
        ServiceOptionNodeFactory $serviceOptionNodeFactory,
        array $serviceKeyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
        $this->serviceKeyYamlToPhpFactories = $serviceKeyYamlToPhpFactories;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
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
            $serviceValues = $serviceValues ?? [];

            foreach ($this->serviceKeyYamlToPhpFactories as $serviceKeyYamlToPhpFactory) {
                if ($serviceKeyYamlToPhpFactory->isMatch($serviceKey, $serviceValues)) {
                    $freshNodes = $serviceKeyYamlToPhpFactory->convertYamlToNodes($serviceKey, $serviceValues);
                    $nodes = array_merge($nodes, $freshNodes);
                    continue 2;
                }
            }

            if ($serviceValues === null) {
                $setMethodCall = $this->singleServicePhpNodeFactory->createSetService($serviceKey);
            } else {
                $args = $this->argsNodeFactory->createFromValues([$serviceKey]);
                $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', $args);
                $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes(
                    $serviceValues,
                    $setMethodCall
                );
            }

            $nodes[] = new Expression($setMethodCall);
        }

        return $nodes;
    }
}
