<?php

declare (strict_types=1);
namespace ConfigTransformer20220613\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer20220613\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer20220613\PHPStan\Analyser\Scope;
use ConfigTransformer20220613\PHPStan\Reflection\ClassReflection;
use ConfigTransformer20220613\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer20220613\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer20220613\PHPStan\Type\MixedType;
use ConfigTransformer20220613\PHPStan\Type\Type;
use ConfigTransformer20220613\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer20220613\Symplify\Astral\Naming\SimpleNameResolver;
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
