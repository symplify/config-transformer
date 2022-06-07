<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\Astral\NodeValue;

use ConfigTransformer202206077\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202206077\PhpParser\ConstExprEvaluator;
use ConfigTransformer202206077\PhpParser\Node\Expr;
use ConfigTransformer202206077\PhpParser\Node\Expr\Cast;
use ConfigTransformer202206077\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202206077\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206077\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202206077\PhpParser\Node\Expr\Variable;
use ConfigTransformer202206077\PHPStan\Analyser\Scope;
use ConfigTransformer202206077\PHPStan\Type\ConstantScalarType;
use ConfigTransformer202206077\PHPStan\Type\UnionType;
use ConfigTransformer202206077\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202206077\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202206077\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202206077\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202206077\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver;
use ConfigTransformer202206077\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver;
use ConfigTransformer202206077\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver;
use ConfigTransformer202206077\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver;
use ConfigTransformer202206077\Symplify\PackageBuilder\Php\TypeChecker;
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
    public function __construct(SimpleNameResolver $simpleNameResolver, TypeChecker $typeChecker, SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->constExprEvaluator = new ConstExprEvaluator(function (Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->unionTypeValueResolver = new UnionTypeValueResolver();
        $this->nodeValueResolvers[] = new ClassConstFetchValueResolver($this->simpleNameResolver, $simpleNodeFinder);
        $this->nodeValueResolvers[] = new ConstFetchValueResolver($this->simpleNameResolver);
        $this->nodeValueResolvers[] = new MagicConstValueResolver();
        $this->nodeValueResolvers[] = new FuncCallValueResolver($this->simpleNameResolver, $this->constExprEvaluator);
    }
    /**
     * @return mixed
     */
    public function resolveWithScope(Expr $expr, Scope $scope)
    {
        $this->currentFilePath = $scope->getFile();
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (ConstExprEvaluationException $exception) {
        }
        $exprType = $scope->getType($expr);
        if ($exprType instanceof ConstantScalarType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof UnionType) {
            return $this->unionTypeValueResolver->resolveConstantTypes($exprType);
        }
        return null;
    }
    /**
     * @return mixed
     */
    public function resolve(Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed
     */
    private function resolveByNode(Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new ShouldNotHappenException();
        }
        foreach ($this->nodeValueResolvers as $nodeValueResolver) {
            if (\is_a($expr, $nodeValueResolver->getType(), \true)) {
                return $nodeValueResolver->resolve($expr, $this->currentFilePath);
            }
        }
        // these values cannot be resolved in reliable way
        if ($this->typeChecker->isInstanceOf($expr, [Variable::class, Cast::class, MethodCall::class, PropertyFetch::class, Instanceof_::class])) {
            throw new ConstExprEvaluationException();
        }
        return null;
    }
}
