<?php

declare (strict_types=1);
namespace ConfigTransformer202201308\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use ConfigTransformer202201308\PhpParser\Node\Arg;
use ConfigTransformer202201308\PhpParser\Node\Expr;
use ConfigTransformer202201308\PhpParser\Node\Expr\Array_;
use ConfigTransformer202201308\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202201308\PhpParser\Node\Expr\Closure;
use ConfigTransformer202201308\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201308\PhpParser\Node\Expr\Variable;
use ConfigTransformer202201308\PhpParser\Node\Identifier;
use ConfigTransformer202201308\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202201308\PhpParser\Node\Param;
use ConfigTransformer202201308\PhpParser\Node\Stmt;
use ConfigTransformer202201308\PhpParser\Node\Stmt\Expression;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202201308\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202201308\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202201308\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202201308\Symplify\PhpConfigPrinter\ValueObject\VariableName;
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
    public function __construct(\ConfigTransformer202201308\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202201308\Symplify\Astral\NodeValue\NodeValueResolver $nodeValueResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->nodeValueResolver = $nodeValueResolver;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts) : \ConfigTransformer202201308\PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \ConfigTransformer202201308\PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam() : \ConfigTransformer202201308\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \ConfigTransformer202201308\PhpParser\Node\Expr\Variable(\ConfigTransformer202201308\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        return new \ConfigTransformer202201308\PhpParser\Node\Param($containerConfiguratorVariable, null, new \ConfigTransformer202201308\PhpParser\Node\Name\FullyQualified(\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class));
    }
    private function createRoutingConfiguratorParam() : \ConfigTransformer202201308\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \ConfigTransformer202201308\PhpParser\Node\Expr\Variable(\ConfigTransformer202201308\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @note must be string to avoid prefixing class
        $classNameFullyQualified = new \ConfigTransformer202201308\PhpParser\Node\Name\FullyQualified('ConfigTransformer202201308\\Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator');
        return new \ConfigTransformer202201308\PhpParser\Node\Param($containerConfiguratorVariable, null, $classNameFullyQualified);
    }
    /**
     * @param Stmt[] $stmts
     */
    private function createClosureFromParamAndStmts(\ConfigTransformer202201308\PhpParser\Node\Param $param, array $stmts) : \ConfigTransformer202201308\PhpParser\Node\Expr\Closure
    {
        $stmts = $this->mergeStmtsFromSameClosure($stmts);
        $closure = new \ConfigTransformer202201308\PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        $closure->returnType = new \ConfigTransformer202201308\PhpParser\Node\Identifier('void');
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
            if (!$stmt instanceof \ConfigTransformer202201308\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $stmt = $stmt->expr;
            if (!$stmt instanceof \ConfigTransformer202201308\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $extensionName = $this->matchExtensionName($stmt);
            if (!\is_string($extensionName)) {
                continue;
            }
            $secondArgOrVariadicPlaceholder = $stmt->args[1];
            if (!$secondArgOrVariadicPlaceholder instanceof \ConfigTransformer202201308\PhpParser\Node\Arg) {
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
            if (!$expression instanceof \ConfigTransformer202201308\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $methodCall = $expression->expr;
            if (!$methodCall instanceof \ConfigTransformer202201308\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $array = new \ConfigTransformer202201308\PhpParser\Node\Expr\Array_($newArrayItems);
            $methodCall->args[1] = new \ConfigTransformer202201308\PhpParser\Node\Arg($array);
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
                if (!$singleExtensionExpr instanceof \ConfigTransformer202201308\PhpParser\Node\Expr\Array_) {
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
        throw new \ConfigTransformer202201308\Symplify\Astral\Exception\ShouldNotHappenException();
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
    private function matchExtensionName(\ConfigTransformer202201308\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        if (!$this->simpleNameResolver->isName($methodCall->name, 'extension')) {
            return null;
        }
        $firstArg = $methodCall->args[0];
        if (!$firstArg instanceof \ConfigTransformer202201308\PhpParser\Node\Arg) {
            return null;
        }
        $extensionName = $this->nodeValueResolver->resolve($firstArg->value, '');
        if (!\is_string($extensionName)) {
            return null;
        }
        return $extensionName;
    }
}
