<?php

declare (strict_types=1);
namespace ConfigTransformer202201309\Symplify\Astral\Reflection;

use ConfigTransformer202201309\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201309\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202201309\PHPStan\Analyser\Scope;
use ConfigTransformer202201309\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202201309\PHPStan\Type\ObjectType;
use ConfigTransformer202201309\PHPStan\Type\ThisType;
use ConfigTransformer202201309\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @api
 */
final class MethodCallParser
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\Reflection\ReflectionParser
     */
    private $reflectionParser;
    public function __construct(\ConfigTransformer202201309\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202201309\Symplify\Astral\Reflection\ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(\ConfigTransformer202201309\PhpParser\Node\Expr\MethodCall $methodCall, \ConfigTransformer202201309\PHPStan\Analyser\Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof \ConfigTransformer202201309\PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \ConfigTransformer202201309\PHPStan\Type\ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202201309\PHPStan\Reflection\ClassReflection) {
            return null;
        }
        $methodName = $this->simpleNameResolver->getName($methodCall->name);
        if ($methodName === null) {
            return null;
        }
        if (!$classReflection->hasNativeMethod($methodName)) {
            return null;
        }
        $methodReflection = $classReflection->getNativeMethod($methodName);
        return $this->reflectionParser->parsePHPStanMethodReflection($methodReflection);
    }
}
