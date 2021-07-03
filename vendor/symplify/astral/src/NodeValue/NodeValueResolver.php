<?php

declare (strict_types=1);
namespace ConfigTransformer202107037\Symplify\Astral\NodeValue;

use ConfigTransformer202107037\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202107037\PhpParser\ConstExprEvaluator;
use ConfigTransformer202107037\PhpParser\Node\Expr;
use ConfigTransformer202107037\PhpParser\Node\Expr\Cast;
use ConfigTransformer202107037\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202107037\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202107037\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202107037\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202107037\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107037\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202107037\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer202107037\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use ConfigTransformer202107037\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202107037\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202107037\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202107037\Symplify\PackageBuilder\Php\TypeChecker;
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
    public function __construct(\ConfigTransformer202107037\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202107037\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer202107037\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->simpleNodeFinder = $simpleNodeFinder;
        $this->constExprEvaluator = new \ConfigTransformer202107037\PhpParser\ConstExprEvaluator(function (\ConfigTransformer202107037\PhpParser\Node\Expr $expr) {
            return $this->resolveByNode($expr);
        });
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolve(\ConfigTransformer202107037\PhpParser\Node\Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202107037\PhpParser\ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed|null
     */
    private function resolveClassConstFetch(\ConfigTransformer202107037\PhpParser\Node\Expr\ClassConstFetch $classConstFetch)
    {
        $className = $this->simpleNameResolver->getName($classConstFetch->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($classConstFetch, \ConfigTransformer202107037\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer202107037\PhpParser\Node\Stmt\ClassLike) {
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
        $reflectionClassConstant = new \ReflectionClassConstant($className, $constantName);
        return $reflectionClassConstant->getValue();
    }
    private function resolveMagicConst(\ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst $magicConst) : ?string
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer202107037\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($magicConst instanceof \ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($this->currentFilePath);
        }
        if ($magicConst instanceof \ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst\File) {
            return $this->currentFilePath;
        }
        return null;
    }
    /**
     * @return mixed|null
     */
    private function resolveConstFetch(\ConfigTransformer202107037\PhpParser\Node\Expr\ConstFetch $constFetch)
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
    private function resolveByNode(\ConfigTransformer202107037\PhpParser\Node\Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer202107037\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($expr instanceof \ConfigTransformer202107037\PhpParser\Node\Scalar\MagicConst) {
            return $this->resolveMagicConst($expr);
        }
        if ($expr instanceof \ConfigTransformer202107037\PhpParser\Node\Expr\FuncCall && $this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($this->currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer202107037\PhpParser\Node\Expr\ConstFetch) {
            return $this->resolveConstFetch($expr);
        }
        if ($expr instanceof \ConfigTransformer202107037\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->resolveClassConstFetch($expr);
        }
        if ($this->typeChecker->isInstanceOf($expr, [\ConfigTransformer202107037\PhpParser\Node\Expr\Variable::class, \ConfigTransformer202107037\PhpParser\Node\Expr\Cast::class, \ConfigTransformer202107037\PhpParser\Node\Expr\MethodCall::class, \ConfigTransformer202107037\PhpParser\Node\Expr\PropertyFetch::class, \ConfigTransformer202107037\PhpParser\Node\Expr\Instanceof_::class])) {
            throw new \ConfigTransformer202107037\PhpParser\ConstExprEvaluationException();
        }
        return null;
    }
}
