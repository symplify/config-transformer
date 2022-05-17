<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer2022051710\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2022051710\PHPStan\Analyser\Scope;
use ConfigTransformer2022051710\PHPStan\Reflection\ClassReflection;
use ConfigTransformer2022051710\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer2022051710\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer2022051710\PHPStan\Type\MixedType;
use ConfigTransformer2022051710\PHPStan\Type\Type;
use ConfigTransformer2022051710\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2022051710\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @api
 */
final class ClassMethodReturnTypeResolver
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer2022051710\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function resolve(\ConfigTransformer2022051710\PhpParser\Node\Stmt\ClassMethod $classMethod, \ConfigTransformer2022051710\PHPStan\Analyser\Scope $scope) : \ConfigTransformer2022051710\PHPStan\Type\Type
    {
        $methodName = $this->simpleNameResolver->getName($classMethod);
        if (!\is_string($methodName)) {
            throw new \ConfigTransformer2022051710\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer2022051710\PHPStan\Reflection\ClassReflection) {
            return new \ConfigTransformer2022051710\PHPStan\Type\MixedType();
        }
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = \ConfigTransformer2022051710\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        if (!$functionVariant instanceof \ConfigTransformer2022051710\PHPStan\Reflection\FunctionVariant) {
            return new \ConfigTransformer2022051710\PHPStan\Type\MixedType();
        }
        return $functionVariant->getReturnType();
    }
}
