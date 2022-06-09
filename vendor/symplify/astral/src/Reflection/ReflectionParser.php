<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\Symplify\Astral\Reflection;

use ConfigTransformer20220609\PhpParser\Node;
use ConfigTransformer20220609\PhpParser\Node\Stmt\Class_;
use ConfigTransformer20220609\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer20220609\PhpParser\Node\Stmt\Property;
use ConfigTransformer20220609\PhpParser\NodeFinder;
use ConfigTransformer20220609\PHPStan\Reflection\ClassReflection;
use ConfigTransformer20220609\PHPStan\Reflection\MethodReflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use ConfigTransformer20220609\Symplify\Astral\PhpParser\SmartPhpParser;
use Throwable;
/**
 * @api
 */
final class ReflectionParser
{
    /**
     * @var array<string, Class_>
     */
    private $classesByFilename = [];
    /**
     * @var \Symplify\Astral\PhpParser\SmartPhpParser
     */
    private $smartPhpParser;
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(SmartPhpParser $smartPhpParser, NodeFinder $nodeFinder)
    {
        $this->smartPhpParser = $smartPhpParser;
        $this->nodeFinder = $nodeFinder;
    }
    public function parsePHPStanMethodReflection(MethodReflection $methodReflection) : ?ClassMethod
    {
        $classReflection = $methodReflection->getDeclaringClass();
        $fileName = $classReflection->getFileName();
        if ($fileName === null) {
            return null;
        }
        $class = $this->parseFilenameToClass($fileName);
        if (!$class instanceof Node) {
            return null;
        }
        return $class->getMethod($methodReflection->getName());
    }
    public function parseMethodReflection(ReflectionMethod $reflectionMethod) : ?ClassMethod
    {
        $class = $this->parseNativeClassReflection($reflectionMethod->getDeclaringClass());
        if (!$class instanceof Class_) {
            return null;
        }
        return $class->getMethod($reflectionMethod->getName());
    }
    public function parsePropertyReflection(ReflectionProperty $reflectionProperty) : ?Property
    {
        $class = $this->parseNativeClassReflection($reflectionProperty->getDeclaringClass());
        if (!$class instanceof Class_) {
            return null;
        }
        return $class->getProperty($reflectionProperty->getName());
    }
    public function parseClassReflection(ClassReflection $classReflection) : ?Class_
    {
        $filename = $classReflection->getFileName();
        if ($filename === null) {
            return null;
        }
        return $this->parseFilenameToClass($filename);
    }
    private function parseNativeClassReflection(ReflectionClass $reflectionClass) : ?Class_
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
        if (isset($this->classesByFilename[$fileName])) {
            return $this->classesByFilename[$fileName];
        }
        try {
            $stmts = $this->smartPhpParser->parseFile($fileName);
        } catch (Throwable $exception) {
            // not reachable
            return null;
        }
        $class = $this->nodeFinder->findFirstInstanceOf($stmts, Class_::class);
        if (!$class instanceof Class_) {
            return null;
        }
        $this->classesByFilename[$fileName] = $class;
        return $class;
    }
}
