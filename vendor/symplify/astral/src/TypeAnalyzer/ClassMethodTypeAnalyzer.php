<?php

declare (strict_types=1);
namespace ConfigTransformer202110116\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer202110116\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202110116\PHPStan\Analyser\Scope;
use ConfigTransformer202110116\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202110116\PHPStan\Type\Type;
use ConfigTransformer202110116\Symplify\PHPStanRules\Exception\ShouldNotHappenException;
final class ClassMethodTypeAnalyzer
{
    public function resolveReturnType(\ConfigTransformer202110116\PhpParser\Node\Stmt\ClassMethod $classMethod, \ConfigTransformer202110116\PHPStan\Analyser\Scope $scope) : \ConfigTransformer202110116\PHPStan\Type\Type
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202110116\PHPStan\Reflection\ClassReflection) {
            throw new \ConfigTransformer202110116\Symplify\PHPStanRules\Exception\ShouldNotHappenException();
        }
        $methodName = (string) $classMethod->name;
        $methodReflection = $classReflection->getNativeMethod($methodName);
        $parametersAcceptor = $methodReflection->getVariants()[0];
        return $parametersAcceptor->getReturnType();
    }
    /**
     * @param string[] $methodNames
     */
    public function isClassMethodOfNamesAndType(\ConfigTransformer202110116\PhpParser\Node\Stmt\ClassMethod $classMethod, \ConfigTransformer202110116\PHPStan\Analyser\Scope $scope, array $methodNames, string $classType) : bool
    {
        $classMethodName = (string) $classMethod->name;
        if (!\in_array($classMethodName, $methodNames, \true)) {
            return \false;
        }
        return $this->isClassType($scope, $classType);
    }
    private function isClassType(\ConfigTransformer202110116\PHPStan\Analyser\Scope $scope, string $classType) : bool
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202110116\PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        if ($classReflection->isSubclassOf($classType)) {
            return \true;
        }
        return $classReflection->hasTraitUse($classType);
    }
}
