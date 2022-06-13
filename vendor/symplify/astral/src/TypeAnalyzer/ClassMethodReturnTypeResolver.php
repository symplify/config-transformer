<?php

declare (strict_types=1);
namespace ConfigTransformer202206\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer202206\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202206\PHPStan\Analyser\Scope;
use ConfigTransformer202206\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202206\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer202206\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer202206\PHPStan\Type\MixedType;
use ConfigTransformer202206\PHPStan\Type\Type;
use ConfigTransformer202206\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202206\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @api
 */
final class ClassMethodReturnTypeResolver
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function resolve(ClassMethod $classMethod, Scope $scope) : Type
    {
        $methodName = $this->simpleNameResolver->getName($classMethod);
        if (!\is_string($methodName)) {
            throw new ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof ClassReflection) {
            return new MixedType();
        }
        $extendedMethodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = ParametersAcceptorSelector::selectSingle($extendedMethodReflection->getVariants());
        if (!$functionVariant instanceof FunctionVariant) {
            return new MixedType();
        }
        return $functionVariant->getReturnType();
    }
}
