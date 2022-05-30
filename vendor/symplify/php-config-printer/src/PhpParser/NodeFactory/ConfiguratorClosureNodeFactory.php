<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use ConfigTransformer2022053010\PhpParser\Node\Arg;
use ConfigTransformer2022053010\PhpParser\Node\Expr;
use ConfigTransformer2022053010\PhpParser\Node\Expr\Array_;
use ConfigTransformer2022053010\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2022053010\PhpParser\Node\Expr\Closure;
use ConfigTransformer2022053010\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022053010\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022053010\PhpParser\Node\Identifier;
use ConfigTransformer2022053010\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2022053010\PhpParser\Node\Param;
use ConfigTransformer2022053010\PhpParser\Node\Stmt;
use ConfigTransformer2022053010\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022053010\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2022053010\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022053010\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Naming\VariableNameResolver;
use ConfigTransformer2022053010\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConfiguratorClosureNodeFactory
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\NodeValue\NodeValueResolver
     */
    private $nodeValueResolver;
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\VariableNameResolver
     */
    private $variableNameResolver;
    public function __construct(\ConfigTransformer2022053010\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2022053010\Symplify\Astral\NodeValue\NodeValueResolver $nodeValueResolver, \ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Naming\VariableNameResolver $variableNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->nodeValueResolver = $nodeValueResolver;
        $this->variableNameResolver = $variableNameResolver;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts, string $containerConfiguratorClass) : \ConfigTransformer2022053010\PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam($containerConfiguratorClass);
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \ConfigTransformer2022053010\PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam(string $containerConfiguratorClass) : \ConfigTransformer2022053010\PhpParser\Node\Param
    {
        $variableName = $this->variableNameResolver->resolveFromType($containerConfiguratorClass);
        $containerConfiguratorVariable = new \ConfigTransformer2022053010\PhpParser\Node\Expr\Variable($variableName);
        $fullyQualified = new \ConfigTransformer2022053010\PhpParser\Node\Name\FullyQualified($containerConfiguratorClass);
        return new \ConfigTransformer2022053010\PhpParser\Node\Param($containerConfiguratorVariable, null, $fullyQualified);
    }
    private function createRoutingConfiguratorParam() : \ConfigTransformer2022053010\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \ConfigTransformer2022053010\PhpParser\Node\Expr\Variable(\ConfigTransformer2022053010\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @note must be string to avoid prefixing class
        $classNameFullyQualified = new \ConfigTransformer2022053010\PhpParser\Node\Name\FullyQualified('ConfigTransformer2022053010\\Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator');
        return new \ConfigTransformer2022053010\PhpParser\Node\Param($containerConfiguratorVariable, null, $classNameFullyQualified);
    }
    /**
     * @param Stmt[] $stmts
     */
    private function createClosureFromParamAndStmts(\ConfigTransformer2022053010\PhpParser\Node\Param $param, array $stmts) : \ConfigTransformer2022053010\PhpParser\Node\Expr\Closure
    {
        $stmts = $this->mergeStmtsFromSameClosure($stmts);
        $closure = new \ConfigTransformer2022053010\PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        $closure->returnType = new \ConfigTransformer2022053010\PhpParser\Node\Identifier('void');
        return $closure;
    }
    /**
     * To avoid multiple arrays for the same extension
     *
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function mergeStmtsFromSameClosure(array $stmts) : array
    {
        $extensionNodes = [];
        foreach ($stmts as $stmtKey => $stmt) {
            if (!$stmt instanceof \ConfigTransformer2022053010\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $stmt = $stmt->expr;
            if (!$stmt instanceof \ConfigTransformer2022053010\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $extensionName = $this->matchExtensionName($stmt);
            if (!\is_string($extensionName)) {
                continue;
            }
            $secondArgOrVariadicPlaceholder = $stmt->args[1];
            if (!$secondArgOrVariadicPlaceholder instanceof \ConfigTransformer2022053010\PhpParser\Node\Arg) {
                continue;
            }
            $extensionNodes[$extensionName][] = [$stmtKey => $secondArgOrVariadicPlaceholder->value];
        }
        if ($extensionNodes === []) {
            return $stmts;
        }
        return $this->replaceArrayArgWithMergedArrayItems($extensionNodes, $stmts);
    }
    /**
     * @param array<string, Expr[][]> $extensionNodesByExtensionName
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function replaceArrayArgWithMergedArrayItems(array $extensionNodesByExtensionName, array $stmts) : array
    {
        foreach ($extensionNodesByExtensionName as $extensionNodes) {
            if (\count($extensionNodes) === 1) {
                continue;
            }
            $firstStmtKey = $this->resolveFirstStmtKey($extensionNodes);
            $stmtKeysToRemove = $this->resolveStmtKeysToRemove($extensionNodes);
            $newArrayItems = $this->resolveMergedArrayItems($extensionNodes);
            foreach ($stmtKeysToRemove as $stmtKeyToRemove) {
                unset($stmts[$stmtKeyToRemove]);
            }
            // replace first extension argument
            $expression = $stmts[$firstStmtKey];
            if (!$expression instanceof \ConfigTransformer2022053010\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $methodCall = $expression->expr;
            if (!$methodCall instanceof \ConfigTransformer2022053010\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $array = new \ConfigTransformer2022053010\PhpParser\Node\Expr\Array_($newArrayItems);
            $methodCall->args[1] = new \ConfigTransformer2022053010\PhpParser\Node\Arg($array);
        }
        return $stmts;
    }
    /**
     * @param Expr[][] $extensionExprs
     * @return array<ArrayItem|null>
     */
    private function resolveMergedArrayItems(array $extensionExprs) : array
    {
        $newArrayItems = [];
        foreach ($extensionExprs as $extensionExpr) {
            foreach ($extensionExpr as $singleExtensionExpr) {
                if (!$singleExtensionExpr instanceof \ConfigTransformer2022053010\PhpParser\Node\Expr\Array_) {
                    continue;
                }
                $newArrayItems = \array_merge($newArrayItems, $singleExtensionExpr->items);
            }
        }
        return $newArrayItems;
    }
    /**
     * @param Expr[][] $extensionStmts
     */
    private function resolveFirstStmtKey(array $extensionStmts) : int
    {
        foreach ($extensionStmts as $extensionStmt) {
            \reset($extensionStmt);
            return (int) \key($extensionStmt);
        }
        throw new \ConfigTransformer2022053010\Symplify\Astral\Exception\ShouldNotHappenException();
    }
    /**
     * @param Expr[][] $extensionStmts
     * @return int[]
     */
    private function resolveStmtKeysToRemove(array $extensionStmts) : array
    {
        $stmtKeysToRemove = [];
        $firstKey = null;
        foreach ($extensionStmts as $extensionStmt) {
            foreach (\array_keys($extensionStmt) as $stmtKey) {
                /** @var int $stmtKey */
                if ($firstKey === null) {
                    $firstKey = $stmtKey;
                } else {
                    $stmtKeysToRemove[] = $stmtKey;
                }
            }
        }
        return $stmtKeysToRemove;
    }
    private function matchExtensionName(\ConfigTransformer2022053010\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        if (!$this->simpleNameResolver->isName($methodCall->name, 'extension')) {
            return null;
        }
        $firstArg = $methodCall->args[0];
        if (!$firstArg instanceof \ConfigTransformer2022053010\PhpParser\Node\Arg) {
            return null;
        }
        $extensionName = $this->nodeValueResolver->resolve($firstArg->value, '');
        if (!\is_string($extensionName)) {
            return null;
        }
        return $extensionName;
    }
}
