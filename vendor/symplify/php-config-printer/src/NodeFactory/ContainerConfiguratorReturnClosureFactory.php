<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2021061110\PhpParser\Node\Expr\Assign;
use ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021061110\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021061110\PhpParser\Node\Stmt;
use ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021061110\PhpParser\Node\Stmt\Return_;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ContainerConfiguratorReturnClosureFactory
{
    /**
     * @var ConfiguratorClosureNodeFactory
     */
    private $configuratorClosureNodeFactory;
    /**
     * @var CaseConverterInterface[]
     */
    private $caseConverters = [];
    /**
     * @var ContainerNestedNodesFactory
     */
    private $containerNestedNodesFactory;
    /**
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, array $caseConverters, \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory $containerNestedNodesFactory)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->containerNestedNodesFactory = $containerNestedNodesFactory;
    }
    /**
     * @param array<string, mixed[]> $arrayData
     */
    public function createFromYamlArray(array $arrayData) : \ConfigTransformer2021061110\PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->configuratorClosureNodeFactory->createContainerClosureFromStmts($stmts);
        return new \ConfigTransformer2021061110\PhpParser\Node\Stmt\Return_($closure);
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
                if (!$expression instanceof \ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression) {
                    continue;
                }
                $nodes[] = $expression;
            }
        }
        return $nodes;
    }
    private function createInitializeAssign(string $variableName, string $methodName) : \ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression
    {
        $servicesVariable = new \ConfigTransformer2021061110\PhpParser\Node\Expr\Variable($variableName);
        $containerConfiguratorVariable = new \ConfigTransformer2021061110\PhpParser\Node\Expr\Variable(\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $assign = new \ConfigTransformer2021061110\PhpParser\Node\Expr\Assign($servicesVariable, new \ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, $methodName));
        return new \ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression($assign);
    }
    /**
     * @return mixed[]
     */
    private function createInitializeNode(string $key, array $nodes) : array
    {
        if ($key === \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES, \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\MethodName::SERVICES);
        }
        if ($key === \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS, \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\MethodName::PARAMETERS);
        }
        return $nodes;
    }
    /**
     * @param int|string $nestedKey
     * @param mixed|mixed[] $nestedValues
     */
    private function resolveExpression(string $key, $nestedKey, $nestedValues) : ?\ConfigTransformer2021061110\PhpParser\Node\Stmt\Expression
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
