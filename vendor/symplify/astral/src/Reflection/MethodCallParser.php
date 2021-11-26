<?php

declare (strict_types=1);
namespace ConfigTransformer202111268\Symplify\Astral\Reflection;

use ConfigTransformer202111268\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202111268\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202111268\PHPStan\Analyser\Scope;
use ConfigTransformer202111268\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202111268\PHPStan\Type\ObjectType;
use ConfigTransformer202111268\PHPStan\Type\ThisType;
use ConfigTransformer202111268\Symplify\Astral\Naming\SimpleNameResolver;
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
    public function __construct(\ConfigTransformer202111268\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202111268\Symplify\Astral\Reflection\ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(\ConfigTransformer202111268\PhpParser\Node\Expr\MethodCall $methodCall, \ConfigTransformer202111268\PHPStan\Analyser\Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof \ConfigTransformer202111268\PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \ConfigTransformer202111268\PHPStan\Type\ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202111268\PHPStan\Reflection\ClassReflection) {
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
