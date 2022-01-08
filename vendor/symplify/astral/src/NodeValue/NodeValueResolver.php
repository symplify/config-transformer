<?php

declare (strict_types=1);
namespace ConfigTransformer202201085\Symplify\Astral\NodeValue;

use ConfigTransformer202201085\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202201085\PhpParser\ConstExprEvaluator;
use ConfigTransformer202201085\PhpParser\Node\Expr;
use ConfigTransformer202201085\PhpParser\Node\Expr\Cast;
use ConfigTransformer202201085\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202201085\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201085\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202201085\PhpParser\Node\Expr\Variable;
use ConfigTransformer202201085\PHPStan\Analyser\Scope;
use ConfigTransformer202201085\PHPStan\Type\ConstantScalarType;
use ConfigTransformer202201085\PHPStan\Type\UnionType;
use ConfigTransformer202201085\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202201085\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202201085\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202201085\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver;
use ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver;
use ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver;
use ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver;
use ConfigTransformer202201085\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 */
final class NodeValueResolver
{
    /**
     * @var \PhpParser\ConstExprEvaluator
     */
    private $constExprEvaluator;
    /**
     * @var string|null
     */
    private $currentFilePath;
    /**
     * @var \Symplify\Astral\NodeValue\UnionTypeValueResolver
     */
    private $unionTypeValueResolver;
    /**
     * @var array<NodeValueResolverInterface>
     */
    private $nodeValueResolvers = [];
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\PackageBuilder\Php\TypeChecker
     */
    private $typeChecker;
    public function __construct(\ConfigTransformer202201085\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202201085\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer202201085\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->constExprEvaluator = new \ConfigTransformer202201085\PhpParser\ConstExprEvaluator(function (\ConfigTransformer202201085\PhpParser\Node\Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->unionTypeValueResolver = new \ConfigTransformer202201085\Symplify\Astral\NodeValue\UnionTypeValueResolver();
        $this->nodeValueResolvers[] = new \ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver($this->simpleNameResolver, $simpleNodeFinder);
        $this->nodeValueResolvers[] = new \ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver($this->simpleNameResolver);
        $this->nodeValueResolvers[] = new \ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver();
        $this->nodeValueResolvers[] = new \ConfigTransformer202201085\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver($this->simpleNameResolver, $this->constExprEvaluator);
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolveWithScope(\ConfigTransformer202201085\PhpParser\Node\Expr $expr, \ConfigTransformer202201085\PHPStan\Analyser\Scope $scope)
    {
        $this->currentFilePath = $scope->getFile();
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202201085\PhpParser\ConstExprEvaluationException $exception) {
        }
        $exprType = $scope->getType($expr);
        if ($exprType instanceof \ConfigTransformer202201085\PHPStan\Type\ConstantScalarType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof \ConfigTransformer202201085\PHPStan\Type\UnionType) {
            return $this->unionTypeValueResolver->resolveConstantTypes($exprType);
        }
        return null;
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolve(\ConfigTransformer202201085\PhpParser\Node\Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202201085\PhpParser\ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed|string|int|bool|null
     */
    private function resolveByNode(\ConfigTransformer202201085\PhpParser\Node\Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer202201085\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        foreach ($this->nodeValueResolvers as $nodeValueResolver) {
            if (\is_a($expr, $nodeValueResolver->getType(), \true)) {
                return $nodeValueResolver->resolve($expr, $this->currentFilePath);
            }
        }
        // these values cannot be resolved in reliable way
        if ($this->typeChecker->isInstanceOf($expr, [\ConfigTransformer202201085\PhpParser\Node\Expr\Variable::class, \ConfigTransformer202201085\PhpParser\Node\Expr\Cast::class, \ConfigTransformer202201085\PhpParser\Node\Expr\MethodCall::class, \ConfigTransformer202201085\PhpParser\Node\Expr\PropertyFetch::class, \ConfigTransformer202201085\PhpParser\Node\Expr\Instanceof_::class])) {
            throw new \ConfigTransformer202201085\PhpParser\ConstExprEvaluationException();
        }
        return null;
    }
}
