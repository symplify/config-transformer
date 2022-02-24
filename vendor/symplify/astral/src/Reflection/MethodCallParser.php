<?php

declare (strict_types=1);
namespace ConfigTransformer202202245\Symplify\Astral\Reflection;

use ConfigTransformer202202245\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202202245\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202202245\PHPStan\Analyser\Scope;
use ConfigTransformer202202245\PHPStan\Reflection\ClassReflection;
use ConfigTransformer202202245\PHPStan\Type\ObjectType;
use ConfigTransformer202202245\PHPStan\Type\ThisType;
use ConfigTransformer202202245\Symplify\Astral\Naming\SimpleNameResolver;
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
    public function __construct(\ConfigTransformer202202245\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202202245\Symplify\Astral\Reflection\ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(\ConfigTransformer202202245\PhpParser\Node\Expr\MethodCall $methodCall, \ConfigTransformer202202245\PHPStan\Analyser\Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof \ConfigTransformer202202245\PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \ConfigTransformer202202245\PHPStan\Type\ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer202202245\PHPStan\Reflection\ClassReflection) {
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
