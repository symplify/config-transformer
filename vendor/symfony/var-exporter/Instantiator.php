<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202201309\Symfony\Component\VarExporter;

use ConfigTransformer202201309\Symfony\Component\VarExporter\Exception\ExceptionInterface;
use ConfigTransformer202201309\Symfony\Component\VarExporter\Exception\NotInstantiableTypeException;
use ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Hydrator;
use ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry;
/**
 * A utility class to create objects without calling their constructor.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class Instantiator
{
    /**
     * Creates an object and sets its properties without calling its constructor nor any other methods.
     *
     * For example:
     *
     *     // creates an empty instance of Foo
     *     Instantiator::instantiate(Foo::class);
     *
     *     // creates a Foo instance and sets one of its properties
     *     Instantiator::instantiate(Foo::class, ['propertyName' => $propertyValue]);
     *
     *     // creates a Foo instance and sets a private property defined on its parent Bar class
     *     Instantiator::instantiate(Foo::class, [], [
     *         Bar::class => ['privateBarProperty' => $propertyValue],
     *     ]);
     *
     * Instances of ArrayObject, ArrayIterator and SplObjectHash can be created
     * by using the special "\0" property name to define their internal value:
     *
     *     // creates an SplObjectHash where $info1 is attached to $obj1, etc.
     *     Instantiator::instantiate(SplObjectStorage::class, ["\0" => [$obj1, $info1, $obj2, $info2...]]);
     *
     *     // creates an ArrayObject populated with $inputArray
     *     Instantiator::instantiate(ArrayObject::class, ["\0" => [$inputArray]]);
     *
     * @param string $class             The class of the instance to create
     * @param array  $properties        The properties to set on the instance
     * @param array  $privateProperties The private properties to set on the instance,
     *                                  keyed by their declaring class
     *
     * @throws ExceptionInterface When the instance cannot be created
     */
    public static function instantiate(string $class, array $properties = [], array $privateProperties = []) : object
    {
        $reflector = \ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::$reflectors[$class] ?? \ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::getClassReflector($class);
        if (\ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::$cloneable[$class]) {
            $wrappedInstance = [clone \ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::$prototypes[$class]];
        } elseif (\ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::$instantiableWithoutConstructor[$class]) {
            $wrappedInstance = [$reflector->newInstanceWithoutConstructor()];
        } elseif (null === \ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Registry::$prototypes[$class]) {
            throw new \ConfigTransformer202201309\Symfony\Component\VarExporter\Exception\NotInstantiableTypeException($class);
        } elseif ($reflector->implementsInterface('Serializable') && !\method_exists($class, '__unserialize')) {
            $wrappedInstance = [\unserialize('C:' . \strlen($class) . ':"' . $class . '":0:{}')];
        } else {
            $wrappedInstance = [\unserialize('O:' . \strlen($class) . ':"' . $class . '":0:{}')];
        }
        if ($properties) {
            $privateProperties[$class] = isset($privateProperties[$class]) ? $properties + $privateProperties[$class] : $properties;
        }
        foreach ($privateProperties as $class => $properties) {
            if (!$properties) {
                continue;
            }
            foreach ($properties as $name => $value) {
                // because they're also used for "unserialization", hydrators
                // deal with array of instances, so we need to wrap values
                $properties[$name] = [$value];
            }
            (\ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Hydrator::$hydrators[$class] ?? \ConfigTransformer202201309\Symfony\Component\VarExporter\Internal\Hydrator::getHydrator($class))($properties, $wrappedInstance);
        }
        return $wrappedInstance[0];
    }
}
