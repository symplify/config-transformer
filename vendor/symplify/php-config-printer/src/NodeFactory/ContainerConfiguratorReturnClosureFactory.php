<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformerPrefix202401\Nette\Utils\Json;
use ConfigTransformerPrefix202401\PhpParser\Node\Arg;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Assign;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\BinaryOp\Identical;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202401\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\Expression;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\If_;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\Return_;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\Exception\ShouldNotHappenException;
use Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableMethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ContainerConfiguratorReturnClosureFactory
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory
     */
    private $configuratorClosureNodeFactory;
    /**
     * @var CaseConverterInterface[]
     * @readonly
     */
    private $caseConverters;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory
     */
    private $containerNestedNodesFactory;
    /**
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, iterable $caseConverters, \Symplify\PhpConfigPrinter\NodeFactory\ContainerNestedNodesFactory $containerNestedNodesFactory)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->containerNestedNodesFactory = $containerNestedNodesFactory;
    }
    /**
     * @param array<string, mixed[]> $arrayData
     * @param string $containerConfiguratorClass Must remain string to avoid prefixing
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
        return $this->createStmtsFromCaseConverters($yamlData);
    }
    /**
     * @param array<string, mixed[]> $yamlData
     * @return Stmt[]
     */
    private function createStmtsFromCaseConverters(array $yamlData) : array
    {
        $stmts = [];
        foreach ($yamlData as $key => $values) {
            // keys can be int, but we need string
            if (!\is_string($key)) {
                $key = (string) $key;
            }
            $stmts = $this->createInitializeStmt($key, $stmts);
            foreach ($values as $nestedKey => $nestedValues) {
                $nestedNodes = $this->processNestedNodes($key, $nestedKey, $nestedValues);
                if ($nestedNodes !== []) {
                    $stmts = \array_merge($stmts, $nestedNodes);
                    continue;
                }
                $expression = $this->resolveStmt($key, $nestedKey, $nestedValues);
                if (!$expression instanceof Expression) {
                    continue;
                }
                $lastNode = \end($stmts);
                $node = $this->resolveExpressionWhenAtEnv($expression, $key, $lastNode);
                if ($node !== null) {
                    $stmts[] = $node;
                }
            }
        }
        return $stmts;
    }
    /**
     * @return Expression[]|mixed[]
     * @param int|string $nestedKey
     * @param mixed $nestedValues
     */
    private function processNestedNodes(string $key, $nestedKey, $nestedValues) : array
    {
        if (\is_array($nestedValues)) {
            return $this->containerNestedNodesFactory->createFromValues($nestedValues, $key, $nestedKey);
        }
        return [];
    }
    /**
     * @param \PhpParser\Node\Stmt\Expression|\PhpParser\Node\Stmt\If_|bool $lastNode
     * @return \PhpParser\Node\Stmt\Expression|\PhpParser\Node\Stmt\If_|null
     */
    private function resolveExpressionWhenAtEnv(Expression $expression, string $key, $lastNode)
    {
        $explodeAt = \explode('@', $key);
        if (\strncmp($key, 'when@', \strlen('when@')) === 0 && \count($explodeAt) === 2) {
            $variable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
            $expr = $expression->expr;
            if (!$expr instanceof MethodCall) {
                throw new ShouldNotHappenException();
            }
            $args = $expr->getArgs();
            if (!isset($args[1]) || !$args[1]->value instanceof Array_ || !isset($args[1]->value->items[0]) || !$args[1]->value->items[0] instanceof ArrayItem || !$args[1]->value->items[0]->key instanceof Expr) {
                throw new ShouldNotHappenException();
            }
            $newExpression = new Expression(new MethodCall($variable, 'extension', [new Arg($args[1]->value->items[0]->key), new Arg($args[1]->value->items[0]->value)]));
            $environmentString = new String_($explodeAt[1]);
            $envMethodCall = new MethodCall($variable, 'env');
            $identical = new Identical($envMethodCall, $environmentString);
            if ($lastNode instanceof If_ && $this->isSameCond($lastNode->cond, $identical)) {
                $lastNode->stmts[] = $newExpression;
                return null;
            }
            $if = new If_($identical);
            $if->stmts = [$newExpression];
            return $if;
        }
        return $expression;
    }
    private function isSameCond(Expr $expr, Identical $identical) : bool
    {
        if ($expr instanceof Identical) {
            $val1 = Json::encode($expr);
            $val2 = Json::encode($identical);
            return $val1 === $val2;
        }
        return \false;
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
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function createInitializeStmt(string $key, array $stmts) : array
    {
        if ($key === YamlKey::SERVICES) {
            $stmts[] = $this->createInitializeAssign(VariableMethodName::SERVICES);
            return $stmts;
        }
        if ($key === YamlKey::PARAMETERS) {
            $stmts[] = $this->createInitializeAssign(VariableMethodName::PARAMETERS);
            return $stmts;
        }
        return $stmts;
    }
    /**
     * @param int|string $nestedKey
     * @param mixed $nestedValues
     */
    private function resolveStmt(string $key, $nestedKey, $nestedValues) : ?Stmt
    {
        foreach ($this->caseConverters as $caseConverter) {
            if (!$caseConverter->match($key, $nestedKey, $nestedValues)) {
                continue;
            }
            /** @var string $nestedKey */
            return $caseConverter->convertToMethodCallStmt($nestedKey, $nestedValues);
        }
        return null;
    }
}
