<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202106110\PhpParser\Node;
use ConfigTransformer202106110\PhpParser\Node\Stmt\Return_;
use ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use ConfigTransformer202106110\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
final class RoutingConfiguratorReturnClosureFactory
{
    /**
     * @var ConfiguratorClosureNodeFactory
     */
    private $containerConfiguratorClosureNodeFactory;
    /**
     * @var RoutingCaseConverterInterface[]
     */
    private $routingCaseConverters = [];
    /**
     * @param RoutingCaseConverterInterface[] $routingCaseConverters
     */
    public function __construct(\ConfigTransformer202106110\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $containerConfiguratorClosureNodeFactory, array $routingCaseConverters)
    {
        $this->containerConfiguratorClosureNodeFactory = $containerConfiguratorClosureNodeFactory;
        $this->routingCaseConverters = $routingCaseConverters;
    }
    public function createFromArrayData(array $arrayData) : \ConfigTransformer202106110\PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->containerConfiguratorClosureNodeFactory->createRoutingClosureFromStmts($stmts);
        return new \ConfigTransformer202106110\PhpParser\Node\Stmt\Return_($closure);
    }
    /**
     * @return mixed[]
     */
    private function createClosureStmts(array $arrayData) : array
    {
        $arrayData = $this->removeEmptyValues($arrayData);
        return $this->createNodesFromCaseConverters($arrayData);
    }
    /**
     * @return mixed[]
     */
    private function removeEmptyValues(array $yamlData) : array
    {
        return \array_filter($yamlData);
    }
    /**
     * @param mixed[] $arrayData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $arrayData) : array
    {
        $nodes = [];
        foreach ($arrayData as $key => $values) {
            $expression = null;
            foreach ($this->routingCaseConverters as $caseConverter) {
                if (!$caseConverter->match($key, $values)) {
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