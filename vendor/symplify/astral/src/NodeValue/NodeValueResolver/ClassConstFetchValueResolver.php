<?php

declare (strict_types=1);
namespace ConfigTransformer2022012610\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer2022012610\PhpParser\Node\Expr;
use ConfigTransformer2022012610\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer2022012610\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use ConfigTransformer2022012610\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer2022012610\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022012610\Symplify\Astral\NodeFinder\SimpleNodeFinder;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ClassConstFetch>
 */
final class ClassConstFetchValueResolver implements \ConfigTransformer2022012610\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\NodeFinder\SimpleNodeFinder
     */
    private $simpleNodeFinder;
    public function __construct(\ConfigTransformer2022012610\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2022012610\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->simpleNodeFinder = $simpleNodeFinder;
    }
    public function getType() : string
    {
        return \ConfigTransformer2022012610\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    /**
     * @param ClassConstFetch $expr
     * @return null|string|mixed
     */
    public function resolve(\ConfigTransformer2022012610\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $className = $this->simpleNameResolver->getName($expr->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($expr, \ConfigTransformer2022012610\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer2022012610\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            $className = $this->simpleNameResolver->getName($classLike);
        }
        if ($className === null) {
            return null;
        }
        $constantName = $this->simpleNameResolver->getName($expr->name);
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
}
