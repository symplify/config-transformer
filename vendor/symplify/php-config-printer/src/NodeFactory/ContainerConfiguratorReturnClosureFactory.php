<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202207\PhpParser\Node\Arg;
use ConfigTransformer202207\PhpParser\Node\Expr\Array_;
use ConfigTransformer202207\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202207\PhpParser\Node\Expr\Assign;
use ConfigTransformer202207\PhpParser\Node\Expr\BinaryOp\Identical;
use ConfigTransformer202207\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202207\PhpParser\Node\Expr\Variable;
use ConfigTransformer202207\PhpParser\Node\Scalar\String_;
use ConfigTransformer202207\PhpParser\Node\Stmt;
use ConfigTransformer202207\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202207\PhpParser\Node\Stmt\If_;
use ConfigTransformer202207\PhpParser\Node\Stmt\Return_;
use ConfigTransformer202207\Symplify\Astral\Exception\ShouldNotHappenException;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableMethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ContainerConfiguratorReturnClosureFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory
     */
    private $configuratorClosureNodeFactory;
    /**
     * @var CaseConverterInterface[]
     */
    private $caseConverters;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory
     */
    private $containerNestedNodesFactory;
    /**
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, array $caseConverters, \Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory $containerNestedNodesFactory)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->containerNestedNodesFactory = $containerNestedNodesFactory;
    }
    /**
     * @param array<string, mixed[]> $arrayData
     */
    public function createFromYamlArray(array $arrayData, string $containerConfiguratorClass = 'Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator') : Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->configuratorClosureNodeFactory->createContainerClosureFromStmts($stmts, $containerConfiguratorClass);
        return new Return_($closure);
    }
    /**
     * @param mixed[] $yamlData
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
                if (!$expression instanceof Expression) {
                    continue;
                }
                $nodes[] = $this->resolveExpressionWhenAtEnv($expression, $key);
            }
        }
        return $nodes;
    }
    /**
     * @return \PhpParser\Node\Stmt\Expression|\PhpParser\Node\Stmt\If_
     */
    private function resolveExpressionWhenAtEnv(Expression $expression, string $key)
    {
        $explodeAt = \explode('@', $key);
        if (\strncmp($key, 'when@', \strlen('when@')) === 0 && \count($explodeAt) === 2) {
            $variable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
            $identical = new Identical(new String_($explodeAt[1]), new MethodCall($variable, 'env'));
            $expr = $expression->expr;
            if (!$expr instanceof MethodCall) {
                throw new ShouldNotHappenException();
            }
            $args = $expr->getArgs();
            if (!isset($args[1]) || !$args[1]->value instanceof Array_ || !isset($args[1]->value->items[0]) || !$args[1]->value->items[0] instanceof ArrayItem) {
                throw new ShouldNotHappenException();
            }
            $newExpression = new Expression(new MethodCall($variable, 'extension', [new Arg(new String_('framework')), new Arg($args[1]->value->items[0]->value)]));
            $if = new If_($identical);
            $if->stmts = [$newExpression];
            return $if;
        }
        return $expression;
    }
    /**
     * @param VariableMethodName::* $variableMethodName
     */
    private function createInitializeAssign(string $variableMethodName) : Expression
    {
        $servicesVariable = new Variable($variableMethodName);
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $assign = new Assign($servicesVariable, new MethodCall($containerConfiguratorVariable, $variableMethodName));
        return new Expression($assign);
    }
    /**
     * @param Expression[]|If_[] $nodes
     * @return Expression[]|If_[]
     */
    private function createInitializeNode(string $key, array $nodes) : array
    {
        if ($key === YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(VariableMethodName::SERVICES);
            return $nodes;
        }
        if ($key === YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(VariableMethodName::PARAMETERS);
            return $nodes;
        }
        return $nodes;
    }
    /**
     * @param int|string $nestedKey
     * @param mixed $nestedValues
     */
    private function resolveExpression(string $key, $nestedKey, $nestedValues) : ?Expression
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
