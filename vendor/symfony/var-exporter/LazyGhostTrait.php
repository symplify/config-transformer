<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Component\VarExporter;

use ConfigTransformerPrefix202507\Symfony\Component\Serializer\Attribute\Ignore;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\Hydrator;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectRegistry as Registry;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectState;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectTrait;
if (\PHP_VERSION_ID >= 80400) {
    trigger_deprecation('symfony/var-exporter', '7.3', 'The "%s" trait is deprecated, use native lazy objects instead.', LazyGhostTrait::class);
}
/**
 * @deprecated since Symfony 7.3, use native lazy objects instead
 */
trait LazyGhostTrait
{
    use LazyObjectTrait;
    /**
     * Creates a lazy-loading ghost instance.
     *
     * Skipped properties should be indexed by their array-cast identifier, see
     * https://php.net/manual/language.types.array#language.types.array.casting
     *
     * @param \Closure(static):void    $initializer       The closure should initialize the object it receives as argument
     * @param array<string, true>|null $skippedProperties An array indexed by the properties to skip, a.k.a. the ones
     *                                                    that the initializer doesn't initialize, if any
     * @param static|null              $instance
     * @return static
     */
    public static function createLazyGhost(\Closure $initializer, ?array $skippedProperties = null, ?object $instance = null)
    {
        if (self::class !== ($class = $instance ? \get_class($instance) : static::class)) {
            $skippedProperties["\x00" . self::class . "\x00lazyObjectState"] = \true;
        }
        if (!isset(Registry::$defaultProperties[$class])) {
            Registry::$classReflectors[$class] = Registry::$classReflectors[$class] ?? new \ReflectionClass($class);
            $instance = $instance ?? Registry::$classReflectors[$class]->newInstanceWithoutConstructor();
            Registry::$defaultProperties[$class] = Registry::$defaultProperties[$class] ?? (array) $instance;
            Registry::$classResetters[$class] = Registry::$classResetters[$class] ?? Registry::getClassResetters($class);
            if (self::class === $class && \defined($class . '::LAZY_OBJECT_PROPERTY_SCOPES')) {
                Hydrator::$propertyScopes[$class] = Hydrator::$propertyScopes[$class] ?? $class::LAZY_OBJECT_PROPERTY_SCOPES;
            }
        } else {
            $instance = $instance ?? Registry::$classReflectors[$class]->newInstanceWithoutConstructor();
        }
        if (isset($instance->lazyObjectState)) {
            $instance->lazyObjectState->initializer = $initializer;
            $instance->lazyObjectState->skippedProperties = $skippedProperties = $skippedProperties ?? [];
            if (LazyObjectState::STATUS_UNINITIALIZED_FULL !== $instance->lazyObjectState->status) {
                $instance->lazyObjectState->reset($instance);
            }
            return $instance;
        }
        $instance->lazyObjectState = new LazyObjectState($initializer, $skippedProperties = $skippedProperties ?? []);
        foreach (Registry::$classResetters[$class] as $reset) {
            $reset($instance, $skippedProperties);
        }
        return $instance;
    }
    /**
     * Returns whether the object is initialized.
     *
     * @param bool $partial Whether partially initialized objects should be considered as initialized
     */
    public function isLazyObjectInitialized(bool $partial = \false) : bool
    {
        if (!($state = $this->lazyObjectState ?? null)) {
            return \true;
        }
        return LazyObjectState::STATUS_INITIALIZED_FULL === $state->status;
    }
    /**
     * Forces initialization of a lazy object and returns it.
     * @return static
     */
    public function initializeLazyObject()
    {
        if (!($state = $this->lazyObjectState ?? null)) {
            return $this;
        }
        if (LazyObjectState::STATUS_UNINITIALIZED_FULL === $state->status) {
            $state->initialize($this, '', null);
        }
        return $this;
    }
    /**
     * @return bool Returns false when the object cannot be reset, ie when it's not a lazy object
     */
    public function resetLazyObject() : bool
    {
        if (!($state = $this->lazyObjectState ?? null)) {
            return \false;
        }
        if (LazyObjectState::STATUS_UNINITIALIZED_FULL !== $state->status) {
            $state->reset($this);
        }
        return \true;
    }
    /**
     * @return mixed
     */
    public function &__get($name)
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        $notByRef = 0;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForRead($propertyScopes, $class, $name);
            $state = $this->lazyObjectState ?? null;
            if ($state && (null === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"]))) {
                $notByRef = $access & Hydrator::PROPERTY_NOT_BY_REF;
                if (LazyObjectState::STATUS_INITIALIZED_FULL === $state->status) {
                    // Work around php/php-src#12695
                    $property = null === $scope ? $name : "\x00{$scope}\x00{$name}";
                    $property = $propertyScopes[$property][4] ?? (Hydrator::$propertyScopes[\get_class($this)][$property][4] = new \ReflectionProperty($scope ?? $class, $name));
                } else {
                    $property = null;
                }
                if (\PHP_VERSION_ID >= 80400 && !$notByRef && $access >> 2 & \ReflectionProperty::IS_PRIVATE_SET) {
                    $scope = $scope ?? $writeScope;
                }
                if ((($nullsafeVariable1 = $property) ? $nullsafeVariable1->isInitialized($this) : null) ?? LazyObjectState::STATUS_UNINITIALIZED_PARTIAL !== $state->initialize($this, $name, $writeScope ?? $scope)) {
                    goto get_in_scope;
                }
            }
        }
        if ($parent = (Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['get']) {
            if (2 === $parent) {
                return parent::__get($name);
            }
            $value = parent::__get($name);
            return $value;
        }
        if (null === $class) {
            $frame = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            \trigger_error(\sprintf('Undefined property: %s::$%s in %s on line %s', \get_class($this), $name, $frame['file'], $frame['line']), \E_USER_NOTICE);
        }
        get_in_scope:
        try {
            if (null === $scope) {
                if (!$notByRef) {
                    return $this->{$name};
                }
                $value = $this->{$name};
                return $value;
            }
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            return $accessor['get']($this, $name, $notByRef);
        } catch (\Error $e) {
            if (\Error::class !== \get_class($e) || \strncmp($e->getMessage(), 'Cannot access uninitialized non-nullable property', \strlen('Cannot access uninitialized non-nullable property')) !== 0) {
                throw $e;
            }
            try {
                if (null === $scope) {
                    $this->{$name} = [];
                    return $this->{$name};
                }
                $accessor['set']($this, $name, []);
                return $accessor['get']($this, $name, $notByRef);
            } catch (\Error $exception) {
                if (\preg_match('/^Cannot access uninitialized non-nullable property ([^ ]++) by reference$/', $e->getMessage(), $matches)) {
                    throw new \Error('Typed property ' . $matches[1] . ' must not be accessed before initialization', $e->getCode(), $e->getPrevious());
                }
                throw $e;
            }
        }
    }
    public function __set($name, $value) : void
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForWrite($propertyScopes, $class, $name, $access >> 2);
            $state = $this->lazyObjectState ?? null;
            if ($state && ($writeScope === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) && LazyObjectState::STATUS_INITIALIZED_FULL !== $state->status) {
                if (LazyObjectState::STATUS_UNINITIALIZED_FULL === $state->status) {
                    $state->initialize($this, $name, $writeScope ?? $scope);
                }
                goto set_in_scope;
            }
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['set']) {
            parent::__set($name, $value);
            return;
        }
        set_in_scope:
        if (null === $scope) {
            $this->{$name} = $value;
        } else {
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            $accessor['set']($this, $name, $value);
        }
    }
    public function __isset($name) : bool
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        if ([$class, , $writeScope] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForRead($propertyScopes, $class, $name);
            $state = $this->lazyObjectState ?? null;
            if ($state && (null === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) && LazyObjectState::STATUS_INITIALIZED_FULL !== $state->status && LazyObjectState::STATUS_UNINITIALIZED_PARTIAL !== $state->initialize($this, $name, $writeScope ?? $scope)) {
                goto isset_in_scope;
            }
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['isset']) {
            return parent::__isset($name);
        }
        isset_in_scope:
        if (null === $scope) {
            return isset($this->{$name});
        }
        $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
        return $accessor['isset']($this, $name);
    }
    public function __unset($name) : void
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForWrite($propertyScopes, $class, $name, $access >> 2);
            $state = $this->lazyObjectState ?? null;
            if ($state && ($writeScope === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) && LazyObjectState::STATUS_INITIALIZED_FULL !== $state->status) {
                if (LazyObjectState::STATUS_UNINITIALIZED_FULL === $state->status) {
                    $state->initialize($this, $name, $writeScope ?? $scope);
                }
                goto unset_in_scope;
            }
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['unset']) {
            parent::__unset($name);
            return;
        }
        unset_in_scope:
        if (null === $scope) {
            unset($this->{$name});
        } else {
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            $accessor['unset']($this, $name);
        }
    }
    public function __clone()
    {
        if ($state = $this->lazyObjectState ?? null) {
            $this->lazyObjectState = clone $state;
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['clone']) {
            parent::__clone();
        }
    }
    public function __serialize() : array
    {
        $class = self::class;
        if ((Registry::$parentMethods[$class] = Registry::$parentMethods[$class] ?? Registry::getParentMethods($class))['serialize']) {
            $properties = parent::__serialize();
        } else {
            $this->initializeLazyObject();
            $properties = (array) $this;
        }
        unset($properties["\x00{$class}\x00lazyObjectState"]);
        if (Registry::$parentMethods[$class]['serialize'] || !Registry::$parentMethods[$class]['sleep']) {
            return $properties;
        }
        $scope = \get_parent_class($class);
        $data = [];
        foreach (parent::__sleep() as $name) {
            $value = $properties[$k = $name] ?? $properties[$k = "\x00*\x00{$name}"] ?? $properties[$k = "\x00{$class}\x00{$name}"] ?? $properties[$k = "\x00{$scope}\x00{$name}"] ?? ($k = null);
            if (null === $k) {
                \trigger_error(\sprintf('serialize(): "%s" returned as member variable from __sleep() but does not exist', $name), \E_USER_NOTICE);
            } else {
                $data[$k] = $value;
            }
        }
        return $data;
    }
    public function __destruct()
    {
        $state = $this->lazyObjectState ?? null;
        if (LazyObjectState::STATUS_UNINITIALIZED_FULL === (($nullsafeVariable2 = $state) ? $nullsafeVariable2->status : null)) {
            return;
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['destruct']) {
            parent::__destruct();
        }
    }
    private function setLazyObjectAsInitialized(bool $initialized) : void
    {
        if ($state = $this->lazyObjectState ?? null) {
            $state->status = $initialized ? LazyObjectState::STATUS_INITIALIZED_FULL : LazyObjectState::STATUS_UNINITIALIZED_FULL;
        }
    }
}
