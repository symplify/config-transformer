<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\VarExporter\Internal;

use ConfigTransformerPrefix202501\Symfony\Component\VarExporter\Exception\ClassNotFoundException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
class Hydrator
{
    /**
     * @readonly
     * @var \Symfony\Component\VarExporter\Internal\Registry
     */
    public $registry;
    /**
     * @readonly
     * @var \Symfony\Component\VarExporter\Internal\Values|null
     */
    public $values;
    /**
     * @readonly
     * @var mixed[]
     */
    public $properties;
    /**
     * @readonly
     * @var mixed
     */
    public $value;
    /**
     * @readonly
     * @var mixed[]
     */
    public $wakeups;
    /**
     * @var mixed[]
     */
    public static $hydrators = [];
    /**
     * @var mixed[]
     */
    public static $simpleHydrators = [];
    /**
     * @var mixed[]
     */
    public static $propertyScopes = [];
    /**
     * @param mixed $value
     */
    public function __construct(Registry $registry, ?Values $values, array $properties, $value, array $wakeups)
    {
        $this->registry = $registry;
        $this->values = $values;
        $this->properties = $properties;
        $this->value = $value;
        $this->wakeups = $wakeups;
    }
    public static function hydrate($objects, $values, $properties, $value, $wakeups)
    {
        foreach ($properties as $class => $vars) {
            (self::$hydrators[$class] = self::$hydrators[$class] ?? self::getHydrator($class))($vars, $objects);
        }
        foreach ($wakeups as $k => $v) {
            if (\is_array($v)) {
                $objects[-$k]->__unserialize($v);
            } else {
                $objects[$v]->__wakeup();
            }
        }
        return $value;
    }
    public static function getHydrator($class)
    {
        $baseHydrator = self::$hydrators['stdClass'] = self::$hydrators['stdClass'] ?? static function ($properties, $objects) {
            foreach ($properties as $name => $values) {
                foreach ($values as $i => $v) {
                    $objects[$i]->{$name} = $v;
                }
            }
        };
        switch ($class) {
            case 'stdClass':
                return $baseHydrator;
            case 'ErrorException':
                return $baseHydrator->bindTo(null, new class extends \ErrorException
                {
                });
            case 'TypeError':
                return $baseHydrator->bindTo(null, new class extends \Error
                {
                });
            case 'SplObjectStorage':
                return static function ($properties, $objects) {
                    foreach ($properties as $name => $values) {
                        if ("\x00" === $name) {
                            foreach ($values as $i => $v) {
                                for ($j = 0; $j < \count($v); ++$j) {
                                    $objects[$i]->attach($v[$j], $v[++$j]);
                                }
                            }
                            continue;
                        }
                        foreach ($values as $i => $v) {
                            $objects[$i]->{$name} = $v;
                        }
                    }
                };
        }
        if (!\class_exists($class) && !\interface_exists($class, \false) && !\trait_exists($class, \false)) {
            throw new ClassNotFoundException($class);
        }
        $classReflector = new \ReflectionClass($class);
        switch ($class) {
            case 'ArrayIterator':
            case 'ArrayObject':
                $constructor = \Closure::fromCallable([$classReflector->getConstructor(), 'invokeArgs']);
                return static function ($properties, $objects) use($constructor) {
                    foreach ($properties as $name => $values) {
                        if ("\x00" !== $name) {
                            foreach ($values as $i => $v) {
                                $objects[$i]->{$name} = $v;
                            }
                        }
                    }
                    foreach ($properties["\x00"] ?? [] as $i => $v) {
                        $constructor($objects[$i], $v);
                    }
                };
        }
        if (!$classReflector->isInternal()) {
            return $baseHydrator->bindTo(null, $class);
        }
        if ($classReflector->name !== $class) {
            return self::$hydrators[$classReflector->name] = self::$hydrators[$classReflector->name] ?? self::getHydrator($classReflector->name);
        }
        $propertySetters = [];
        foreach ($classReflector->getProperties() as $propertyReflector) {
            if (!$propertyReflector->isStatic()) {
                $propertySetters[$propertyReflector->name] = \Closure::fromCallable([$propertyReflector, 'setValue']);
            }
        }
        if (!$propertySetters) {
            return $baseHydrator;
        }
        return static function ($properties, $objects) use($propertySetters) {
            foreach ($properties as $name => $values) {
                if ($setValue = $propertySetters[$name] ?? null) {
                    foreach ($values as $i => $v) {
                        $setValue($objects[$i], $v);
                    }
                    continue;
                }
                foreach ($values as $i => $v) {
                    $objects[$i]->{$name} = $v;
                }
            }
        };
    }
    public static function getSimpleHydrator($class)
    {
        $baseHydrator = self::$simpleHydrators['stdClass'] = self::$simpleHydrators['stdClass'] ?? (function ($properties, $object) {
            $readonly = (array) $this;
            foreach ($properties as $name => &$value) {
                $object->{$name} = $value;
                if (!($readonly[$name] ?? \false)) {
                    $object->{$name} =& $value;
                }
            }
        })->bindTo(new \stdClass());
        switch ($class) {
            case 'stdClass':
                return $baseHydrator;
            case 'ErrorException':
                return $baseHydrator->bindTo(new \stdClass(), new class extends \ErrorException
                {
                });
            case 'TypeError':
                return $baseHydrator->bindTo(new \stdClass(), new class extends \Error
                {
                });
            case 'SplObjectStorage':
                return static function ($properties, $object) {
                    foreach ($properties as $name => &$value) {
                        if ("\x00" !== $name) {
                            $object->{$name} = $value;
                            $object->{$name} =& $value;
                            continue;
                        }
                        for ($i = 0; $i < \count($value); ++$i) {
                            $object->attach($value[$i], $value[++$i]);
                        }
                    }
                };
        }
        if (!\class_exists($class) && !\interface_exists($class, \false) && !\trait_exists($class, \false)) {
            throw new ClassNotFoundException($class);
        }
        $classReflector = new \ReflectionClass($class);
        switch ($class) {
            case 'ArrayIterator':
            case 'ArrayObject':
                $constructor = \Closure::fromCallable([$classReflector->getConstructor(), 'invokeArgs']);
                return static function ($properties, $object) use($constructor) {
                    foreach ($properties as $name => &$value) {
                        if ("\x00" === $name) {
                            $constructor($object, $value);
                        } else {
                            $object->{$name} = $value;
                            $object->{$name} =& $value;
                        }
                    }
                };
        }
        if (!$classReflector->isInternal()) {
            $readonly = new \stdClass();
            foreach ($classReflector->getProperties(\ReflectionProperty::IS_READONLY) as $propertyReflector) {
                if ($class === $propertyReflector->class) {
                    $readonly->{$propertyReflector->name} = \true;
                }
            }
            return $baseHydrator->bindTo($readonly, $class);
        }
        if ($classReflector->name !== $class) {
            return self::$simpleHydrators[$classReflector->name] = self::$simpleHydrators[$classReflector->name] ?? self::getSimpleHydrator($classReflector->name);
        }
        $propertySetters = [];
        foreach ($classReflector->getProperties() as $propertyReflector) {
            if (!$propertyReflector->isStatic()) {
                $propertySetters[$propertyReflector->name] = \Closure::fromCallable([$propertyReflector, 'setValue']);
            }
        }
        if (!$propertySetters) {
            return $baseHydrator;
        }
        return static function ($properties, $object) use($propertySetters) {
            foreach ($properties as $name => &$value) {
                if ($setValue = $propertySetters[$name] ?? null) {
                    $setValue($object, $value);
                } else {
                    $object->{$name} = $value;
                    $object->{$name} =& $value;
                }
            }
        };
    }
    public static function getPropertyScopes($class) : array
    {
        $propertyScopes = [];
        $r = new \ReflectionClass($class);
        foreach ($r->getProperties() as $property) {
            $flags = $property->getModifiers();
            if (\ReflectionProperty::IS_STATIC & $flags) {
                continue;
            }
            $name = $property->name;
            $readonlyScope = null;
            if (\ReflectionProperty::IS_PRIVATE & $flags) {
                if ($flags & \ReflectionProperty::IS_READONLY) {
                    $readonlyScope = $class;
                }
                $propertyScopes["\x00{$class}\x00{$name}"] = $propertyScopes[$name] = [$class, $name, $readonlyScope, $property];
                continue;
            }
            if ($flags & \ReflectionProperty::IS_READONLY) {
                $readonlyScope = $property->class;
            }
            $propertyScopes[$name] = [$class, $name, $readonlyScope, $property];
            if (\ReflectionProperty::IS_PROTECTED & $flags) {
                $propertyScopes["\x00*\x00{$name}"] = $propertyScopes[$name];
            }
        }
        while ($r = $r->getParentClass()) {
            $class = $r->name;
            foreach ($r->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
                if (!$property->isStatic()) {
                    $name = $property->name;
                    $readonlyScope = $property->isReadOnly() ? $class : null;
                    $propertyScopes["\x00{$class}\x00{$name}"] = [$class, $name, $readonlyScope, $property];
                    $propertyScopes[$name] = $propertyScopes[$name] ?? [$class, $name, $readonlyScope, $property];
                }
            }
        }
        return $propertyScopes;
    }
}
