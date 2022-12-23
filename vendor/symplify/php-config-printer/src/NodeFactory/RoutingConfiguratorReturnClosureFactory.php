<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202212\PhpParser\Node\Stmt;
use ConfigTransformer202212\PhpParser\Node\Stmt\Return_;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
/**
 * @api
 */
final class RoutingConfiguratorReturnClosureFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory
     */
    private $containerConfiguratorClosureNodeFactory;
    /**
     * @var RoutingCaseConverterInterface[]
     */
    private $routingCaseConverters;
    /**
     * @param RoutingCaseConverterInterface[] $routingCaseConverters
     */
    public function __construct(ConfiguratorClosureNodeFactory $containerConfiguratorClosureNodeFactory, array $routingCaseConverters)
    {
        $this->containerConfiguratorClosureNodeFactory = $containerConfiguratorClosureNodeFactory;
        $this->routingCaseConverters = $routingCaseConverters;
    }
    /**
     * @param mixed[] $arrayData
     */
    public function createFromArrayData(array $arrayData) : Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->containerConfiguratorClosureNodeFactory->createRoutingClosureFromStmts($stmts);
        return new Return_($closure);
    }
    /**
     * @param mixed[] $arrayData
     * @return Stmt[]
     */
    public function createClosureStmts(array $arrayData) : array
    {
        $arrayData = $this->removeEmptyValues($arrayData);
        return $this->createStmtsFromCaseConverters($arrayData);
    }
    /**
     * @param mixed[] $yamlData
     * @return mixed[]
     */
    private function removeEmptyValues(array $yamlData) : array
    {
        return \array_filter($yamlData);
    }
    /**
     * @param mixed[] $arrayData
     * @return Stmt[]
     */
    private function createStmtsFromCaseConverters(array $arrayData) : array
    {
        $stmts = [];
        foreach ($arrayData as $key => $values) {
            $stmt = null;
            foreach ($this->routingCaseConverters as $routingCaseConverter) {
                if (!$routingCaseConverter->match($key, $values)) {
                    continue;
                }
                $stmt = $routingCaseConverter->convertToMethodCall($key, $values);
                break;
            }
            if (!$stmt instanceof Stmt) {
                continue;
            }
            $stmts[] = $stmt;
        }
        return $stmts;
    }
}
