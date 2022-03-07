<?php

declare (strict_types=1);
namespace ConfigTransformer202203078\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer202203078\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202203078\PHPStan\Analyser\Scope;
use ConfigTransformer202203078\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202203078\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer202203078\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer202203078\PHPStan\Type\MixedType;
use ConfigTransformer202203078\PHPStan\Type\Type;
use ConfigTransformer202203078\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202203078\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @api
 */
final class ClassMethodReturnTypeResolver
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer202203078\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function resolve(\ConfigTransformer202203078\PhpParser\Node\Stmt\ClassMethod $classMethod, \ConfigTransformer202203078\PHPStan\Analyser\Scope $scope) : \ConfigTransformer202203078\PHPStan\Type\Type
    {
        $methodName = $this->simpleNameResolver->getName($classMethod);
        if (!\is_string($methodName)) {
            throw new \ConfigTransformer202203078\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202203078\PHPStan\Reflection\ClassReflection) {
            return new \ConfigTransformer202203078\PHPStan\Type\MixedType();
        }
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = \ConfigTransformer202203078\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        if (!$functionVariant instanceof \ConfigTransformer202203078\PHPStan\Reflection\FunctionVariant) {
            return new \ConfigTransformer202203078\PHPStan\Type\MixedType();
        }
        return $functionVariant->getReturnType();
    }
}
