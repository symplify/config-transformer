<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use ConfigTransformer202206075\PhpParser\Node\Arg;
use ConfigTransformer202206075\PhpParser\Node\Expr;
use ConfigTransformer202206075\PhpParser\Node\Expr\Array_;
use ConfigTransformer202206075\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202206075\PhpParser\Node\Expr\Closure;
use ConfigTransformer202206075\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206075\PhpParser\Node\Expr\Variable;
use ConfigTransformer202206075\PhpParser\Node\Identifier;
use ConfigTransformer202206075\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202206075\PhpParser\Node\Param;
use ConfigTransformer202206075\PhpParser\Node\Stmt;
use ConfigTransformer202206075\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202206075\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202206075\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202206075\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\Naming\VariableNameResolver;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\ValueObject\VariableName;
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
    public function __construct(SimpleNameResolver $simpleNameResolver, NodeValueResolver $nodeValueResolver, VariableNameResolver $variableNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->nodeValueResolver = $nodeValueResolver;
        $this->variableNameResolver = $variableNameResolver;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts, string $containerConfiguratorClass) : Closure
    {
        $param = $this->createContainerConfiguratorParam($containerConfiguratorClass);
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam(string $containerConfiguratorClass) : Param
    {
        $variableName = $this->variableNameResolver->resolveFromType($containerConfiguratorClass);
        $containerConfiguratorVariable = new Variable($variableName);
        $fullyQualified = new FullyQualified($containerConfiguratorClass);
        return new Param($containerConfiguratorVariable, null, $fullyQualified);
    }
    private function createRoutingConfiguratorParam() : Param
    {
        $containerConfiguratorVariable = new Variable(VariableName::ROUTING_CONFIGURATOR);
        // @note must be string to avoid prefixing class
        $classNameFullyQualified = new FullyQualified('ConfigTransformer202206075\\Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator');
        return new Param($containerConfiguratorVariable, null, $classNameFullyQualified);
    }
    /**
     * @param Stmt[] $stmts
     */
    private function createClosureFromParamAndStmts(Param $param, array $stmts) : Closure
    {
        $stmts = $this->mergeStmtsFromSameClosure($stmts);
        $closure = new Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        $closure->returnType = new Identifier('void');
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
            if (!$stmt instanceof Expression) {
                continue;
            }
            $stmt = $stmt->expr;
            if (!$stmt instanceof MethodCall) {
                continue;
            }
            $extensionName = $this->matchExtensionName($stmt);
            if (!\is_string($extensionName)) {
                continue;
            }
            $secondArgOrVariadicPlaceholder = $stmt->args[1];
            if (!$secondArgOrVariadicPlaceholder instanceof Arg) {
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
            if (!$expression instanceof Expression) {
                continue;
            }
            $methodCall = $expression->expr;
            if (!$methodCall instanceof MethodCall) {
                continue;
            }
            $array = new Array_($newArrayItems);
            $methodCall->args[1] = new Arg($array);
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
                if (!$singleExtensionExpr instanceof Array_) {
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
        throw new ShouldNotHappenException();
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
    private function matchExtensionName(MethodCall $methodCall) : ?string
    {
        if (!$this->simpleNameResolver->isName($methodCall->name, 'extension')) {
            return null;
        }
        $firstArg = $methodCall->args[0];
        if (!$firstArg instanceof Arg) {
            return null;
        }
        $extensionName = $this->nodeValueResolver->resolve($firstArg->value, '');
        if (!\is_string($extensionName)) {
            return null;
        }
        return $extensionName;
    }
}
