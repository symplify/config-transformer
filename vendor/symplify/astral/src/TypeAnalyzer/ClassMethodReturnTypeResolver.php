<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer20220609\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer20220609\PHPStan\Analyser\Scope;
use ConfigTransformer20220609\PHPStan\Reflection\ClassReflection;
use ConfigTransformer20220609\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer20220609\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer20220609\PHPStan\Type\MixedType;
use ConfigTransformer20220609\PHPStan\Type\Type;
use ConfigTransformer20220609\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer20220609\Symplify\Astral\Naming\SimpleNameResolver;
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
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        if (!$functionVariant instanceof FunctionVariant) {
            return new MixedType();
        }
        return $functionVariant->getReturnType();
    }
}
