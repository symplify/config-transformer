<?php

declare (strict_types=1);
namespace ConfigTransformer2022030310\Symplify\Astral\Reflection;

use ConfigTransformer2022030310\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022030310\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2022030310\PHPStan\Analyser\Scope;
use ConfigTransformer2022030310\PHPStan\Reflection\ClassReflection;
use ConfigTransformer2022030310\PHPStan\Type\ObjectType;
use ConfigTransformer2022030310\PHPStan\Type\ThisType;
use ConfigTransformer2022030310\Symplify\Astral\Naming\SimpleNameResolver;
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
    public function __construct(\ConfigTransformer2022030310\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2022030310\Symplify\Astral\Reflection\ReflectionParser $reflectionParser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->reflectionParser = $reflectionParser;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function parseMethodCall(\ConfigTransformer2022030310\PhpParser\Node\Expr\MethodCall $methodCall, \ConfigTransformer2022030310\PHPStan\Analyser\Scope $scope)
    {
        $callerType = $scope->getType($methodCall->var);
        if ($callerType instanceof \ConfigTransformer2022030310\PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \ConfigTransformer2022030310\PHPStan\Type\ObjectType) {
            return null;
        }
        $classReflection = $callerType->getClassReflection();
        if (!$classReflection instanceof \ConfigTransformer2022030310\PHPStan\Reflection\ClassReflection) {
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
