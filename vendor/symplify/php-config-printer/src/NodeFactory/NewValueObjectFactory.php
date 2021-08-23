<?php

declare (strict_types=1);
namespace ConfigTransformer202108230\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202108230\MyCLabs\Enum\Enum;
use ConfigTransformer202108230\PhpParser\BuilderHelpers;
use ConfigTransformer202108230\PhpParser\Node\Arg;
use ConfigTransformer202108230\PhpParser\Node\Expr\Array_;
use ConfigTransformer202108230\PhpParser\Node\Expr\New_;
use ConfigTransformer202108230\PhpParser\Node\Expr\StaticCall;
use ConfigTransformer202108230\PhpParser\Node\Name\FullyQualified;
use ReflectionClass;
final class NewValueObjectFactory
{
    /**
     * @return \PhpParser\Node\Expr\New_|\PhpParser\Node\Expr\StaticCall
     * @param object $valueObject
     */
    public function create($valueObject)
    {
        $valueObjectClass = \get_class($valueObject);
        if ($valueObject instanceof \ConfigTransformer202108230\MyCLabs\Enum\Enum) {
            return new \ConfigTransformer202108230\PhpParser\Node\Expr\StaticCall(new \ConfigTransformer202108230\PhpParser\Node\Name\FullyQualified($valueObjectClass), $valueObject->getKey());
        }
        $propertyValues = $this->resolvePropertyValuesFromValueObject($valueObjectClass, $valueObject);
        $args = $this->createArgs($propertyValues);
        return new \ConfigTransformer202108230\PhpParser\Node\Expr\New_(new \ConfigTransformer202108230\PhpParser\Node\Name\FullyQualified($valueObjectClass), $args);
    }
    /**
     * @return mixed[]
     * @param object $valueObject
     */
    private function resolvePropertyValuesFromValueObject(string $valueObjectClass, $valueObject) : array
    {
        $reflectionClass = new \ReflectionClass($valueObjectClass);
        $propertyValues = [];
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(\true);
            $propertyValues[] = $reflectionProperty->getValue($valueObject);
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
                $args[] = new \ConfigTransformer202108230\PhpParser\Node\Arg($nestedValueObject);
            } elseif (\is_array($propertyValue)) {
                $args[] = new \ConfigTransformer202108230\PhpParser\Node\Arg(new \ConfigTransformer202108230\PhpParser\Node\Expr\Array_($this->createArgs($propertyValue)));
            } else {
                $args[] = new \ConfigTransformer202108230\PhpParser\Node\Arg(\ConfigTransformer202108230\PhpParser\BuilderHelpers::normalizeValue($propertyValue));
            }
        }
        return $args;
    }
}
