<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2021061210\PhpParser\BuilderHelpers;
use ConfigTransformer2021061210\PhpParser\Node\Arg;
use ConfigTransformer2021061210\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021061210\PhpParser\Node\Expr\New_;
use ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified;
use ReflectionClass;
final class NewValueObjectFactory
{
    /**
     * @param object $valueObject
     */
    public function create($valueObject) : \ConfigTransformer2021061210\PhpParser\Node\Expr\New_
    {
        $valueObjectClass = \get_class($valueObject);
        $propertyValues = $this->resolvePropertyValuesFromValueObject($valueObjectClass, $valueObject);
        $args = $this->createArgs($propertyValues);
        return new \ConfigTransformer2021061210\PhpParser\Node\Expr\New_(new \ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified($valueObjectClass), $args);
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
                $args[] = new \ConfigTransformer2021061210\PhpParser\Node\Arg($resolvedNestedObject = $this->create($propertyValue));
            } elseif (\is_array($propertyValue)) {
                $args[] = new \ConfigTransformer2021061210\PhpParser\Node\Arg(new \ConfigTransformer2021061210\PhpParser\Node\Expr\Array_($this->createArgs($propertyValue)));
            } else {
                $args[] = new \ConfigTransformer2021061210\PhpParser\Node\Arg(\ConfigTransformer2021061210\PhpParser\BuilderHelpers::normalizeValue($propertyValue));
            }
        }
        return $args;
    }
}
