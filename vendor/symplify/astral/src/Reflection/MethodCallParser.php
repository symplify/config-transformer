<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\Reflection;

use ConfigTransformer2022060710\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022060710\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2022060710\PHPStan\Analyser\Scope;
use ConfigTransformer2022060710\PHPStan\Reflection\ClassReflection;
use ConfigTransformer2022060710\PHPStan\Type\ObjectType;
use ConfigTransformer2022060710\PHPStan\Type\ThisType;
use ConfigTransformer2022060710\Symplify\Astral\Naming\SimpleNameResolver;
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
    public function __construct(SimpleNameResolver $simpleNameResolver, ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(MethodCall $methodCall, Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof ClassReflection) {
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
