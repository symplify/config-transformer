<?php

declare (strict_types=1);
namespace ConfigTransformer2021091710\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use ConfigTransformer2021091710\PhpParser\Node\Expr;
use ConfigTransformer2021091710\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021091710\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2021091710\PhpParser\Node\Expr\Closure;
use ConfigTransformer2021091710\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021091710\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021091710\PhpParser\Node\Identifier;
use ConfigTransformer2021091710\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021091710\PhpParser\Node\Param;
use ConfigTransformer2021091710\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021091710\PhpParser\Node\Stmt;
use ConfigTransformer2021091710\PhpParser\Node\Stmt\Expression;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021091710\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConfiguratorClosureNodeFactory
{
    /**
     * @param Stmt[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts) : \ConfigTransformer2021091710\PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \ConfigTransformer2021091710\PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam() : \ConfigTransformer2021091710\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \ConfigTransformer2021091710\PhpParser\Node\Expr\Variable(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        return new \ConfigTransformer2021091710\PhpParser\Node\Param($containerConfiguratorVariable, null, new \ConfigTransformer2021091710\PhpParser\Node\Name\FullyQualified(\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class));
    }
    private function createRoutingConfiguratorParam() : \ConfigTransformer2021091710\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \ConfigTransformer2021091710\PhpParser\Node\Expr\Variable(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @note must be string to avoid prefixing class
        $classNameFullyQualified = new \ConfigTransformer2021091710\PhpParser\Node\Name\FullyQualified('ConfigTransformer2021091710\\Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator');
        return new \ConfigTransformer2021091710\PhpParser\Node\Param($containerConfiguratorVariable, null, $classNameFullyQualified);
    }
    /**
     * @param Stmt[] $stmts
     */
    private function createClosureFromParamAndStmts(\ConfigTransformer2021091710\PhpParser\Node\Param $param, array $stmts) : \ConfigTransformer2021091710\PhpParser\Node\Expr\Closure
    {
        $stmts = $this->mergeStmtsFromSameClosure($stmts);
        $closure = new \ConfigTransformer2021091710\PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        $closure->returnType = new \ConfigTransformer2021091710\PhpParser\Node\Identifier('void');
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
            if (!$stmt instanceof \ConfigTransformer2021091710\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $stmt = $stmt->expr;
            if (!$stmt instanceof \ConfigTransformer2021091710\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            if ($stmt->name instanceof \ConfigTransformer2021091710\PhpParser\Node\Expr) {
                continue;
            }
            if ((string) $stmt->name !== 'extension') {
                continue;
            }
            $firstArgValue = $stmt->args[0]->value;
            if (!$firstArgValue instanceof \ConfigTransformer2021091710\PhpParser\Node\Scalar\String_) {
                continue;
            }
            $extensionName = $firstArgValue->value;
            $extensionNodes[$extensionName][] = [$stmtKey => $stmt->args[1]->value];
        }
        if ($extensionNodes === []) {
            return $stmts;
        }
        return $this->replaceArrayArgWithMergedArrayItems($extensionNodes, $stmts);
    }
    /**
     * @param Expr[][][] $extensionNodes
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function replaceArrayArgWithMergedArrayItems(array $extensionNodes, array $stmts) : array
    {
        foreach ($extensionNodes as $extensionStmts) {
            if (\count($extensionStmts) === 1) {
                continue;
            }
            $firstStmtKey = $this->resolveFirstStmtKey($extensionStmts);
            $stmtKeysToRemove = $this->resolveStmtKeysToRemove($extensionStmts);
            $newArrayItems = $this->resolveMergedArrayItems($extensionStmts);
            foreach ($stmtKeysToRemove as $stmtKeyToRemove) {
                unset($stmts[$stmtKeyToRemove]);
            }
            // replace first extension argument
            $expressoin = $stmts[$firstStmtKey];
            if (!$expressoin instanceof \ConfigTransformer2021091710\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $methodCall = $expressoin->expr;
            if (!$methodCall instanceof \ConfigTransformer2021091710\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $methodCall->args[1]->value = new \ConfigTransformer2021091710\PhpParser\Node\Expr\Array_($newArrayItems);
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
        foreach ($extensionExprs as $stmtKeyToArray) {
            foreach ($stmtKeyToArray as $array) {
                if (!$array instanceof \ConfigTransformer2021091710\PhpParser\Node\Expr\Array_) {
                    continue;
                }
                $newArrayItems = \array_merge($newArrayItems, $array->items);
            }
        }
        return $newArrayItems;
    }
    /**
     * @param Expr[][] $extensionStmts
     */
    private function resolveFirstStmtKey(array $extensionStmts) : int
    {
        foreach ($extensionStmts as $stmtKeyToArray) {
            \reset($stmtKeyToArray);
            return (int) \key($stmtKeyToArray);
        }
        throw new \ConfigTransformer2021091710\Symplify\Astral\Exception\ShouldNotHappenException();
    }
    /**
     * @param Expr[][] $extensionStmts
     * @return int[]
     */
    private function resolveStmtKeysToRemove(array $extensionStmts) : array
    {
        $stmtKeysToRemove = [];
        $firstKey = null;
        foreach ($extensionStmts as $stmtKeyToArray) {
            foreach (\array_keys($stmtKeyToArray) as $stmtKey) {
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
}
