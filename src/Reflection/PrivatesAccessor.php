<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Reflection;

use ReflectionProperty;
final class PrivatesAccessor
{
    // read private property
    /**
     * @return mixed
     */
    public static function readPrivateProperty(object $object, string $propertyName)
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(\true);
        return $reflectionProperty->getValue($object);
    }
    // write private property
    /**
     * @param mixed $value
     */
    public static function writePrivateProperty(object $object, string $propertyName, $value) : void
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(\true);
        $reflectionProperty->setValue($object, $value);
    }
}
