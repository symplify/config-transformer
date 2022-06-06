<?php

declare (strict_types=1);
namespace ConfigTransformer202206065\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer202206065\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202206065\PHPStan\Analyser\Scope;
use ConfigTransformer202206065\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202206065\PHPStan\Reflection\FunctionVariant;
use ConfigTransformer202206065\PHPStan\Reflection\ParametersAcceptorSelector;
use ConfigTransformer202206065\PHPStan\Type\MixedType;
use ConfigTransformer202206065\PHPStan\Type\Type;
use ConfigTransformer202206065\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202206065\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @api
 */
final class ClassMethodReturnTypeResolver
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer202206065\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function resolve(\ConfigTransformer202206065\PhpParser\Node\Stmt\ClassMethod $classMethod, \ConfigTransformer202206065\PHPStan\Analyser\Scope $scope) : \ConfigTransformer202206065\PHPStan\Type\Type
    {
        $methodName = $this->simpleNameResolver->getName($classMethod);
        if (!\is_string($methodName)) {
            throw new \ConfigTransformer202206065\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202206065\PHPStan\Reflection\ClassReflection) {
            return new \ConfigTransformer202206065\PHPStan\Type\MixedType();
        }
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = \ConfigTransformer202206065\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        if (!$functionVariant instanceof \ConfigTransformer202206065\PHPStan\Reflection\FunctionVariant) {
            return new \ConfigTransformer202206065\PHPStan\Type\MixedType();
        }
        return $functionVariant->getReturnType();
    }
}
