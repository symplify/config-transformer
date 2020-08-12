<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\RoutingCaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class RoutingConfiguratorReturnClosureFactory
{
    /**
     * @var ClosureNodeFactory
     */
    private $closureNodeFactory;

    /**
     * @var RoutingCaseConverterInterface[]
     */
    private $routingCaseConverters = [];

    /**
     * @param RoutingCaseConverterInterface[] $routingCaseConverters
     */
    public function __construct(ClosureNodeFactory $closureNodeFactory, array $routingCaseConverters)
    {
        $this->closureNodeFactory = $closureNodeFactory;
        $this->routingCaseConverters = $routingCaseConverters;
    }

    public function createFromYamlArray(array $yamlArray): Return_
    {
        $closureStmts = $this->createClosureStmts($yamlArray);

        $closure = $this->closureNodeFactory->createClosureFromStmts(
            $closureStmts,
            VariableName::ROUTING_CONFIGURATOR,
            RoutingConfigurator::class
        );

        return new Return_($closure);
    }

    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData): array
    {
        $yamlData = $this->removeEmptyValues($yamlData);
        return $this->createNodesFromCaseConverters($yamlData);
    }

    private function removeEmptyValues(array $yamlData): array
    {
        return array_filter($yamlData);
    }

    /**
     * @param mixed[] $yamlData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $yamlData): array
    {
        $nodes = [];

        foreach ($yamlData as $key => $values) {
            $expression = null;

            foreach ($this->routingCaseConverters as $caseConverter) {
                if (! $caseConverter->match($key, $values)) {
                    continue;
                }

                $expression = $caseConverter->convertToMethodCall($key, $values);
                break;
            }

            if ($expression === null) {
                continue;
            }

            $nodes[] = $expression;
        }

        return $nodes;
    }
}
