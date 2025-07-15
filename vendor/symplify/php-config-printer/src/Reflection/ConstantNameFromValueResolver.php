<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Reflection;

use ReflectionClass;
final class ConstantNameFromValueResolver
{
    /**
     * @param class-string $class
     * @param int|string $constantValue
     */
    public function resolveFromValueAndClass($constantValue, string $class) : ?string
    {
        $reflectionClass = new ReflectionClass($class);
        /** @var array<string, mixed> $constants */
        $constants = $reflectionClass->getConstants();
        foreach ($constants as $name => $value) {
            if ($value === $constantValue) {
                return $name;
            }
        }
        return null;
    }
}
