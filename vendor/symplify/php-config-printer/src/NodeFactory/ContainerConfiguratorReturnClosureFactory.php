<?php

declare (strict_types=1);
namespace ConfigTransformer202107232\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202107232\PhpParser\Node\Expr\Assign;
use ConfigTransformer202107232\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107232\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107232\PhpParser\Node\Stmt;
use ConfigTransformer202107232\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107232\PhpParser\Node\Stmt\Return_;
use ConfigTransformer202107232\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202107232\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ContainerConfiguratorReturnClosureFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory
     */
    private $configuratorClosureNodeFactory;
    /**
     * @var mixed[]
     */
    private $caseConverters;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory
     */
    private $containerNestedNodesFactory;
    /**
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(\ConfigTransformer202107232\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, array $caseConverters, \ConfigTransformer202107232\Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory $containerNestedNodesFactory)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->containerNestedNodesFactory = $containerNestedNodesFactory;
    }
    /**
     * @param array<string, mixed[]> $arrayData
     */
    public function createFromYamlArray(array $arrayData) : \ConfigTransformer202107232\PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->configuratorClosureNodeFactory->createContainerClosureFromStmts($stmts);
        return new \ConfigTransformer202107232\PhpParser\Node\Stmt\Return_($closure);
    }
    /**
     * @return Stmt[]
     */
    private function createClosureStmts(array $yamlData) : array
    {
        $yamlData = \array_filter($yamlData);
        return $this->createNodesFromCaseConverters($yamlData);
    }
    /**
     * @param array<string, mixed[]> $yamlData
     * @return Stmt[]
     */
    private function createNodesFromCaseConverters(array $yamlData) : array
    {
        $nodes = [];
        foreach ($yamlData as $key => $values) {
            $nodes = $this->createInitializeNode($key, $nodes);
            foreach ($values as $nestedKey => $nestedValues) {
                $nestedNodes = [];
                if (\is_array($nestedValues)) {
                    $nestedNodes = $this->containerNestedNodesFactory->createFromValues($nestedValues, $key, $nestedKey);
                }
                if ($nestedNodes !== []) {
                    $nodes = \array_merge($nodes, $nestedNodes);
                    continue;
                }
                $expression = $this->resolveExpression($key, $nestedKey, $nestedValues);
                if (!$expression instanceof \ConfigTransformer202107232\PhpParser\Node\Stmt\Expression) {
                    continue;
                }
                $nodes[] = $expression;
            }
        }
        return $nodes;
    }
    private function createInitializeAssign(string $variableName, string $methodName) : \ConfigTransformer202107232\PhpParser\Node\Stmt\Expression
    {
        $servicesVariable = new \ConfigTransformer202107232\PhpParser\Node\Expr\Variable($variableName);
        $containerConfiguratorVariable = new \ConfigTransformer202107232\PhpParser\Node\Expr\Variable(\ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $assign = new \ConfigTransformer202107232\PhpParser\Node\Expr\Assign($servicesVariable, new \ConfigTransformer202107232\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, $methodName));
        return new \ConfigTransformer202107232\PhpParser\Node\Stmt\Expression($assign);
    }
    /**
     * @return mixed[]
     */
    private function createInitializeNode(string $key, array $nodes) : array
    {
        if ($key === \ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(\ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES, \ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\MethodName::SERVICES);
        }
        if ($key === \ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(\ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS, \ConfigTransformer202107232\Symplify\PhpConfigPrinter\ValueObject\MethodName::PARAMETERS);
        }
        return $nodes;
    }
    /**
     * @param mixed|mixed[] $nestedValues
     * @param int|string $nestedKey
     */
    private function resolveExpression(string $key, $nestedKey, $nestedValues) : ?\ConfigTransformer202107232\PhpParser\Node\Stmt\Expression
    {
        foreach ($this->caseConverters as $caseConverter) {
            if (!$caseConverter->match($key, $nestedKey, $nestedValues)) {
                continue;
            }
            /** @var string $nestedKey */
            return $caseConverter->convertToMethodCall($nestedKey, $nestedValues);
        }
        return null;
    }
}
