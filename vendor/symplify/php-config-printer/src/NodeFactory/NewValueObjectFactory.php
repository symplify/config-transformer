<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer20220611\MyCLabs\Enum\Enum;
use ConfigTransformer20220611\PhpParser\BuilderHelpers;
use ConfigTransformer20220611\PhpParser\Node\Arg;
use ConfigTransformer20220611\PhpParser\Node\Expr\Array_;
use ConfigTransformer20220611\PhpParser\Node\Expr\New_;
use ConfigTransformer20220611\PhpParser\Node\Expr\StaticCall;
use ConfigTransformer20220611\PhpParser\Node\Name\FullyQualified;
use ReflectionClass;
final class NewValueObjectFactory
{
    /**
     * @return \PhpParser\Node\Expr\New_|\PhpParser\Node\Expr\StaticCall
     */
    public function create(object $valueObject)
    {
        $valueObjectClass = \get_class($valueObject);
        if ($valueObject instanceof Enum) {
            return new StaticCall(new FullyQualified($valueObjectClass), $valueObject->getKey());
        }
        // assumption that constructor parameters share the same value as property names
        $propertyValues = $this->resolvePropertyValuesFromValueObject($valueObjectClass, $valueObject);
        $args = $this->createArgs($propertyValues);
        return new New_(new FullyQualified($valueObjectClass), $args);
    }
    /**
     * @return mixed[]
     */
    private function resolvePropertyValuesFromValueObject(string $valueObjectClass, object $valueObject) : array
    {
        $reflectionClass = new ReflectionClass($valueObjectClass);
        $propertyValues = [];
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(\true);
            $defaultPropertyValue = $reflectionProperty->getDeclaringClass()->getDefaultProperties()[$reflectionProperty->getName()] ?? null;
            $currentPropertyValue = $reflectionProperty->getValue($valueObject);
            // do not fill in default values
            if ($defaultPropertyValue === $currentPropertyValue) {
                continue;
            }
            $propertyValues[] = $currentPropertyValue;
        }
        return $propertyValues;
    }
    /**
     * @param mixed[] $propertyValues
     * @return Arg[]
     */
    private function createArgs(array $propertyValues) : array
    {
        $args = [];
        foreach ($propertyValues as $propertyValue) {
            if (\is_object($propertyValue)) {
                $nestedValueObject = $this->create($propertyValue);
                $args[] = new Arg($nestedValueObject);
            } elseif (\is_array($propertyValue)) {
                $args[] = new Arg(new Array_($this->createArgs($propertyValue)));
            } else {
                $args[] = new Arg(BuilderHelpers::normalizeValue($propertyValue));
            }
        }
        return $args;
    }
}
