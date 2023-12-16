<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Reflection;

use ReflectionProperty;

final class PrivatesAccessor
{
    // read private property
    public static function readPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object);
    }

    // write private property
    public static function writePrivateProperty(object $object, string $propertyName, mixed $value): void
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(true);

        $reflectionProperty->setValue($object, $value);
    }
}
