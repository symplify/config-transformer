<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\Astral\NodeValue;

use ConfigTransformer202106110\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202106110\PhpParser\ConstExprEvaluator;
use ConfigTransformer202106110\PhpParser\Node\Expr;
use ConfigTransformer202106110\PhpParser\Node\Expr\Cast;
use ConfigTransformer202106110\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202106110\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202106110\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202106110\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202106110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106110\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202106110\PhpParser\Node\Expr\Variable;
use ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer202106110\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use ConfigTransformer202106110\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202106110\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202106110\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 */
final class NodeValueResolver
{
    /**
     * @var ConstExprEvaluator
     */
    private $constExprEvaluator;
    /**
     * @var SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var TypeChecker
     */
    private $typeChecker;
    /**
     * @var string
     */
    private $currentFilePath;
    /**
     * @var SimpleNodeFinder
     */
    private $simpleNodeFinder;
    public function __construct(\ConfigTransformer202106110\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202106110\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer202106110\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->constExprEvaluator = new \ConfigTransformer202106110\PhpParser\ConstExprEvaluator(function (\ConfigTransformer202106110\PhpParser\Node\Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->typeChecker = $typeChecker;
        $this->simpleNodeFinder = $simpleNodeFinder;
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolve(\ConfigTransformer202106110\PhpParser\Node\Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer202106110\PhpParser\ConstExprEvaluationException $constExprEvaluationException) {
            return null;
        }
    }
    /**
     * @return mixed|null
     */
    private function resolveClassConstFetch(\ConfigTransformer202106110\PhpParser\Node\Expr\ClassConstFetch $classConstFetch)
    {
        $className = $this->simpleNameResolver->getName($classConstFetch->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($classConstFetch, \ConfigTransformer202106110\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer202106110\PhpParser\Node\Stmt\ClassLike) {
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
    private function resolveMagicConst(\ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst $magicConst) : ?string
    {
        if ($magicConst instanceof \ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($this->currentFilePath);
        }
        if ($magicConst instanceof \ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst\File) {
            return $this->currentFilePath;
        }
        return null;
    }
    /**
     * @return mixed|null
     */
    private function resolveConstFetch(\ConfigTransformer202106110\PhpParser\Node\Expr\ConstFetch $constFetch)
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
    private function resolveByNode(\ConfigTransformer202106110\PhpParser\Node\Expr $expr)
    {
        if ($expr instanceof \ConfigTransformer202106110\PhpParser\Node\Scalar\MagicConst) {
            return $this->resolveMagicConst($expr);
        }
        if ($expr instanceof \ConfigTransformer202106110\PhpParser\Node\Expr\FuncCall && $this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($this->currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer202106110\PhpParser\Node\Expr\ConstFetch) {
            return $this->resolveConstFetch($expr);
        }
        if ($expr instanceof \ConfigTransformer202106110\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->resolveClassConstFetch($expr);
        }
        if ($this->typeChecker->isInstanceOf($expr, [\ConfigTransformer202106110\PhpParser\Node\Expr\Variable::class, \ConfigTransformer202106110\PhpParser\Node\Expr\Cast::class, \ConfigTransformer202106110\PhpParser\Node\Expr\MethodCall::class, \ConfigTransformer202106110\PhpParser\Node\Expr\PropertyFetch::class, \ConfigTransformer202106110\PhpParser\Node\Expr\Instanceof_::class])) {
            throw new \ConfigTransformer202106110\PhpParser\ConstExprEvaluationException();
        }
        return null;
    }
}