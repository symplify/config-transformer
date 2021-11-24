<?php

declare (strict_types=1);
namespace ConfigTransformer202111242\Symplify\Astral\Reflection;

use ConfigTransformer202111242\PhpParser\Node\Stmt\Class_;
use ConfigTransformer202111242\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202111242\PhpParser\Node\Stmt\Property;
use ConfigTransformer202111242\PhpParser\NodeFinder;
use ReflectionMethod;
use ReflectionProperty;
use ConfigTransformer202111242\Symplify\Astral\PhpParser\SmartPhpParser;
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
    public function __construct(\ConfigTransformer202111242\Symplify\Astral\PhpParser\SmartPhpParser $smartPhpParser, \ConfigTransformer202111242\PhpParser\NodeFinder $nodeFinder)
    {
        $this->smartPhpParser = $smartPhpParser;
        $this->nodeFinder = $nodeFinder;
    }
    public function parseMethodReflectionToClassMethod(\ReflectionMethod $reflectionMethod) : ?\ConfigTransformer202111242\PhpParser\Node\Stmt\ClassMethod
    {
        $class = $this->parseReflectionToClass($reflectionMethod);
        if (!$class instanceof \ConfigTransformer202111242\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class->getMethod($reflectionMethod->getName());
    }
    public function parsePropertyReflectionToProperty(\ReflectionProperty $reflectionProperty) : ?\ConfigTransformer202111242\PhpParser\Node\Stmt\Property
    {
        $class = $this->parseReflectionToClass($reflectionProperty);
        if (!$class instanceof \ConfigTransformer202111242\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class->getProperty($reflectionProperty->getName());
    }
    /**
     * @param \ReflectionMethod|\ReflectionProperty $reflector
     */
    private function parseReflectionToClass($reflector) : ?\ConfigTransformer202111242\PhpParser\Node\Stmt\Class_
    {
        $reflectionClass = $reflector->getDeclaringClass();
        $fileName = $reflectionClass->getFileName();
        if ($fileName === \false) {
            return null;
        }
        try {
            $stmts = $this->smartPhpParser->parseFile($fileName);
        } catch (\Throwable $exception) {
            // not reachable
            return null;
        }
        $class = $this->nodeFinder->findFirstInstanceOf($stmts, \ConfigTransformer202111242\PhpParser\Node\Stmt\Class_::class);
        if (!$class instanceof \ConfigTransformer202111242\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class;
    }
}
