<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\Astral\Reflection;

use ConfigTransformer2022052410\PhpParser\Node;
use ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_;
use ConfigTransformer2022052410\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2022052410\PhpParser\Node\Stmt\Property;
use ConfigTransformer2022052410\PhpParser\NodeFinder;
use ConfigTransformer2022052410\PHPStan\Reflection\MethodReflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use ConfigTransformer2022052410\Symplify\Astral\PhpParser\SmartPhpParser;
use Throwable;
/**
 * @api
 */
final class ReflectionParser
{
    /**
     * @var \Symplify\Astral\PhpParser\SmartPhpParser
     */
    private $smartPhpParser;
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(\ConfigTransformer2022052410\Symplify\Astral\PhpParser\SmartPhpParser $smartPhpParser, \ConfigTransformer2022052410\PhpParser\NodeFinder $nodeFinder)
    {
        $this->smartPhpParser = $smartPhpParser;
        $this->nodeFinder = $nodeFinder;
    }
    public function parsePHPStanMethodReflection(\ConfigTransformer2022052410\PHPStan\Reflection\MethodReflection $methodReflection) : ?\ConfigTransformer2022052410\PhpParser\Node\Stmt\ClassMethod
    {
        $classReflection = $methodReflection->getDeclaringClass();
        $fileName = $classReflection->getFileName();
        if ($fileName === null) {
            return null;
        }
        $class = $this->parseFilenameToClass($fileName);
        if (!$class instanceof \ConfigTransformer2022052410\PhpParser\Node) {
            return null;
        }
        return $class->getMethod($methodReflection->getName());
    }
    public function parseMethodReflection(\ReflectionMethod $reflectionMethod) : ?\ConfigTransformer2022052410\PhpParser\Node\Stmt\ClassMethod
    {
        $class = $this->parseNativeClassReflection($reflectionMethod->getDeclaringClass());
        if (!$class instanceof \ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class->getMethod($reflectionMethod->getName());
    }
    public function parsePropertyReflection(\ReflectionProperty $reflectionProperty) : ?\ConfigTransformer2022052410\PhpParser\Node\Stmt\Property
    {
        $class = $this->parseNativeClassReflection($reflectionProperty->getDeclaringClass());
        if (!$class instanceof \ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class->getProperty($reflectionProperty->getName());
    }
    private function parseNativeClassReflection(\ReflectionClass $reflectionClass) : ?\ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_
    {
        $fileName = $reflectionClass->getFileName();
        if ($fileName === \false) {
            return null;
        }
        return $this->parseFilenameToClass($fileName);
    }
    /**
     * @return \PhpParser\Node\Stmt\Class_|null
     */
    private function parseFilenameToClass(string $fileName)
    {
        try {
            $stmts = $this->smartPhpParser->parseFile($fileName);
        } catch (\Throwable $exception) {
            // not reachable
            return null;
        }
        $class = $this->nodeFinder->findFirstInstanceOf($stmts, \ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_::class);
        if (!$class instanceof \ConfigTransformer2022052410\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class;
    }
}
