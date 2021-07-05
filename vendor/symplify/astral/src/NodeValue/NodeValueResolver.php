<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\Astral\NodeValue;

use ConfigTransformer2021070510\PhpParser\ConstExprEvaluationException;
use ConfigTransformer2021070510\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021070510\PhpParser\Node\Expr;
use ConfigTransformer2021070510\PhpParser\Node\Expr\Cast;
use ConfigTransformer2021070510\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer2021070510\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021070510\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021070510\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021070510\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer2021070510\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer2021070510\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use ConfigTransformer2021070510\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2021070510\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2021070510\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2021070510\Symplify\PackageBuilder\Php\TypeChecker;
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
    public function __construct(\ConfigTransformer2021070510\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2021070510\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \ConfigTransformer2021070510\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->simpleNodeFinder = $simpleNodeFinder;
        $this->constExprEvaluator = new \ConfigTransformer2021070510\PhpParser\ConstExprEvaluator(function (\ConfigTransformer2021070510\PhpParser\Node\Expr $expr) {
            return $this->resolveByNode($expr);
        });
    }
    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function resolve(\ConfigTransformer2021070510\PhpParser\Node\Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\ConfigTransformer2021070510\PhpParser\ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed|null
     */
    private function resolveClassConstFetch(\ConfigTransformer2021070510\PhpParser\Node\Expr\ClassConstFetch $classConstFetch)
    {
        $className = $this->simpleNameResolver->getName($classConstFetch->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($classConstFetch, \ConfigTransformer2021070510\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer2021070510\PhpParser\Node\Stmt\ClassLike) {
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
    private function resolveMagicConst(\ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst $magicConst) : ?string
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer2021070510\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($magicConst instanceof \ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($this->currentFilePath);
        }
        if ($magicConst instanceof \ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst\File) {
            return $this->currentFilePath;
        }
        return null;
    }
    /**
     * @return mixed|null
     */
    private function resolveConstFetch(\ConfigTransformer2021070510\PhpParser\Node\Expr\ConstFetch $constFetch)
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
    private function resolveByNode(\ConfigTransformer2021070510\PhpParser\Node\Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new \ConfigTransformer2021070510\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        if ($expr instanceof \ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst) {
            return $this->resolveMagicConst($expr);
        }
        if ($expr instanceof \ConfigTransformer2021070510\PhpParser\Node\Expr\FuncCall && $this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($this->currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer2021070510\PhpParser\Node\Expr\ConstFetch) {
            return $this->resolveConstFetch($expr);
        }
        if ($expr instanceof \ConfigTransformer2021070510\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->resolveClassConstFetch($expr);
        }
        if ($this->typeChecker->isInstanceOf($expr, [\ConfigTransformer2021070510\PhpParser\Node\Expr\Variable::class, \ConfigTransformer2021070510\PhpParser\Node\Expr\Cast::class, \ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall::class, \ConfigTransformer2021070510\PhpParser\Node\Expr\PropertyFetch::class, \ConfigTransformer2021070510\PhpParser\Node\Expr\Instanceof_::class])) {
            throw new \ConfigTransformer2021070510\PhpParser\ConstExprEvaluationException();
        }
        return null;
    }
}
