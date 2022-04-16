<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\Symplify\Astral\Reflection;

use ConfigTransformer202204166\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202204166\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202204166\PHPStan\Analyser\Scope;
use ConfigTransformer202204166\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202204166\PHPStan\Type\ObjectType;
use ConfigTransformer202204166\PHPStan\Type\ThisType;
use ConfigTransformer202204166\Symplify\Astral\Naming\SimpleNameResolver;
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
    public function __construct(\ConfigTransformer202204166\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202204166\Symplify\Astral\Reflection\ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(\ConfigTransformer202204166\PhpParser\Node\Expr\MethodCall $methodCall, \ConfigTransformer202204166\PHPStan\Analyser\Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof \ConfigTransformer202204166\PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \ConfigTransformer202204166\PHPStan\Type\ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202204166\PHPStan\Reflection\ClassReflection) {
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
