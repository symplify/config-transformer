<?php

declare (strict_types=1);
namespace ConfigTransformer202109139\Symplify\Astral\NodeValue;

use ConfigTransformer202109139\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202109139\PhpParser\ConstExprEvaluator;
use ConfigTransformer202109139\PhpParser\Node\Expr;
use ConfigTransformer202109139\PhpParser\Node\Expr\Cast;
use ConfigTransformer202109139\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202109139\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202109139\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202109139\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202109139\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202109139\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202109139\PhpParser\Node\Expr\Variable;
use ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer202109139\PhpParser\Node\Stmt\ClassLike;
use ConfigTransformer202109139\PHPStan\Analyser\Scope;
use ConfigTransformer202109139\PHPStan\Type\Constant\ConstantBooleanType;
use ConfigTransformer202109139\PHPStan\Type\Constant\ConstantFloatType;
use ConfigTransformer202109139\PHPStan\Type\Constant\ConstantIntegerType;
use ConfigTransformer202109139\PHPStan\Type\Constant\ConstantStringType;
use ReflectionClassConstant;
use ConfigTransformer202109139\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202109139\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202109139\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202109139\Symplify\PackageBuilder\Php\TypeChecker;
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
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\PackageBuilder\Php\TypeChecker
     */
    private $typeChecker;
    /**
     * @var \Symplify\Astral\NodeFinder\SimpleNodeFinder
     */
    private $simpleNodeFinder;
    public function __construct(\ConfigTransformer202109139\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202109139\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer202109139\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->simpleNodeFinder = $simpleNodeFinder;
        $this->constExprEvaluator = new \ConfigTransformer202109139\PhpParser\ConstExprEvaluator(function (\ConfigTransformer202109139\PhpParser\Node\Expr $expr) {
            return $this->resolveByNode($expr);
        });
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolveWithScope(\ConfigTransformer202109139\PhpParser\Node\Expr $expr, \ConfigTransformer202109139\PHPStan\Analyser\Scope $scope)
    {
        $this->currentFilePath = $scope->getFile();
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202109139\PhpParser\ConstExprEvaluationException $exception) {
        }
        $exprType = $scope->getType($expr);
        if ($exprType instanceof \ConfigTransformer202109139\PHPStan\Type\Constant\ConstantStringType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof \ConfigTransformer202109139\PHPStan\Type\Constant\ConstantIntegerType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof \ConfigTransformer202109139\PHPStan\Type\Constant\ConstantBooleanType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof \ConfigTransformer202109139\PHPStan\Type\Constant\ConstantFloatType) {
            return $exprType->getValue();
        }
        return null;
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolve(\ConfigTransformer202109139\PhpParser\Node\Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202109139\PhpParser\ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed|null
     */
    private function resolveClassConstFetch(\ConfigTransformer202109139\PhpParser\Node\Expr\ClassConstFetch $classConstFetch)
    {
        $className = $this->simpleNameResolver->getName($classConstFetch->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($classConstFetch, \ConfigTransformer202109139\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer202109139\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            $className = $this->simpleNameResolver->getName($classLike);
        }
        if ($className === null) {
            return null;
        }
        $constantName = $this->simpleNameResolver->getName($classConstFetch->name);
        if ($constantName === null) {
            return null;
        }
        if ($constantName === 'class') {
            return $className;
        }
        if (!\class_exists($className) && !\interface_exists($className)) {
            return null;
        }
        $reflectionClassConstant = new \ReflectionClassConstant($className, $constantName);
        return $reflectionClassConstant->getValue();
    }
    private function resolveMagicConst(\ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst $magicConst) : ?string
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer202109139\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($magicConst instanceof \ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($this->currentFilePath);
        }
        if ($magicConst instanceof \ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst\File) {
            return $this->currentFilePath;
        }
        return null;
    }
    /**
     * @return mixed|null
     */
    private function resolveConstFetch(\ConfigTransformer202109139\PhpParser\Node\Expr\ConstFetch $constFetch)
    {
        $constFetchName = $this->simpleNameResolver->getName($constFetch);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
    /**
     * @return mixed|string|int|bool|null
     */
    private function resolveByNode(\ConfigTransformer202109139\PhpParser\Node\Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer202109139\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($expr instanceof \ConfigTransformer202109139\PhpParser\Node\Scalar\MagicConst) {
            return $this->resolveMagicConst($expr);
        }
        if ($expr instanceof \ConfigTransformer202109139\PhpParser\Node\Expr\FuncCall && $this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($this->currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer202109139\PhpParser\Node\Expr\ConstFetch) {
            return $this->resolveConstFetch($expr);
        }
        if ($expr instanceof \ConfigTransformer202109139\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->resolveClassConstFetch($expr);
        }
        if ($this->typeChecker->isInstanceOf($expr, [\ConfigTransformer202109139\PhpParser\Node\Expr\Variable::class, \ConfigTransformer202109139\PhpParser\Node\Expr\Cast::class, \ConfigTransformer202109139\PhpParser\Node\Expr\MethodCall::class, \ConfigTransformer202109139\PhpParser\Node\Expr\PropertyFetch::class, \ConfigTransformer202109139\PhpParser\Node\Expr\Instanceof_::class])) {
            throw new \ConfigTransformer202109139\PhpParser\ConstExprEvaluationException();
        }
        return null;
    }
}
