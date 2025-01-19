<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Reflection;

use ReflectionProperty;
final class PrivatesAccessor
{
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
