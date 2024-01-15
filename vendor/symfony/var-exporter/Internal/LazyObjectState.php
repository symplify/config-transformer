<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202401\Symfony\Component\VarExporter\Internal;

use ConfigTransformerPrefix202401\Symfony\Component\VarExporter\Hydrator as PublicHydrator;
/**
 * Keeps the state of lazy objects.
 *
 * As a micro-optimization, this class uses no type declarations.
 *
 * @internal
 */
class LazyObjectState
{
    /**
     * @readonly
     * @var \Closure
     */
    public $initializer;
    public const STATUS_UNINITIALIZED_FULL = 1;
    public const STATUS_UNINITIALIZED_PARTIAL = 2;
    public const STATUS_INITIALIZED_FULL = 3;
    public const STATUS_INITIALIZED_PARTIAL = 4;
    /**
     * @var array<string, true>
     * @readonly
     */
    public $skippedProperties;
    /**
     * @var self::STATUS_*
     */
    public $status = 0;
    /**
     * @var object
     */
    public $realInstance;
    public function __construct(\Closure $initializer, $skippedProperties = [])
    {
        $this->initializer = $initializer;
        $this->skippedProperties = $skippedProperties;
        $this->status = self::STATUS_UNINITIALIZED_FULL;
    }
    public function initialize($instance, $propertyName, $propertyScope)
    {
        if (self::STATUS_UNINITIALIZED_FULL !== $this->status) {
            return $this->status;
        }
        $this->status = self::STATUS_INITIALIZED_PARTIAL;
        try {
            if ($defaultProperties = \array_diff_key(LazyObjectRegistry::$defaultProperties[\get_class($instance)], $this->skippedProperties)) {
                PublicHydrator::hydrate($instance, $defaultProperties);
            }
            ($this->initializer)($instance);
        } catch (\Throwable $e) {
            $this->status = self::STATUS_UNINITIALIZED_FULL;
            $this->reset($instance);
            throw $e;
        }
        return $this->status = self::STATUS_INITIALIZED_FULL;
    }
    public function reset($instance) : void
    {
        $class = \get_class($instance);
        $propertyScopes = Hydrator::$propertyScopes[$class] = Hydrator::$propertyScopes[$class] ?? Hydrator::getPropertyScopes($class);
        $skippedProperties = $this->skippedProperties;
        $properties = (array) $instance;
        foreach ($propertyScopes as $key => [$scope, $name, $readonlyScope]) {
            $propertyScopes[$k = "\x00{$scope}\x00{$name}"] ?? $propertyScopes[$k = "\x00*\x00{$name}"] ?? ($k = $name);
            if ($k === $key && (null !== $readonlyScope || !\array_key_exists($k, $properties))) {
                $skippedProperties[$k] = \true;
            }
        }
        foreach (LazyObjectRegistry::$classResetters[$class] as $reset) {
            $reset($instance, $skippedProperties);
        }
        $this->status = self::STATUS_UNINITIALIZED_FULL;
    }
}