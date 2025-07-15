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
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Hydrator as PublicHydrator;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\Hydrator;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectRegistry as Registry;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectState;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectTrait;
if (\PHP_VERSION_ID >= 80400) {
    trigger_deprecation('symfony/var-exporter', '7.3', 'The "%s" trait is deprecated, use native lazy objects instead.', LazyProxyTrait::class);
}
/**
 * @deprecated since Symfony 7.3, use native lazy objects instead
 */
trait LazyProxyTrait
{
    use LazyObjectTrait;
    /**
     * Creates a lazy-loading virtual proxy.
     *
     * @param \Closure():object $initializer Returns the proxied object
     * @param static|null       $instance
     * @return static
     */
    public static function createLazyProxy(\Closure $initializer, ?object $instance = null)
    {
        if (self::class !== ($class = $instance ? \get_class($instance) : static::class)) {
            $skippedProperties = ["\x00" . self::class . "\x00lazyObjectState" => \true];
        }
        if (!isset(Registry::$defaultProperties[$class])) {
            Registry::$classReflectors[$class] = Registry::$classReflectors[$class] ?? new \ReflectionClass($class);
            $instance = $instance ?? Registry::$classReflectors[$class]->newInstanceWithoutConstructor();
            Registry::$defaultProperties[$class] = Registry::$defaultProperties[$class] ?? (array) $instance;
            if (self::class === $class && \defined($class . '::LAZY_OBJECT_PROPERTY_SCOPES')) {
                Hydrator::$propertyScopes[$class] = Hydrator::$propertyScopes[$class] ?? $class::LAZY_OBJECT_PROPERTY_SCOPES;
            }
            Registry::$classResetters[$class] = Registry::$classResetters[$class] ?? Registry::getClassResetters($class);
        } else {
            $instance = $instance ?? Registry::$classReflectors[$class]->newInstanceWithoutConstructor();
        }
        if (isset($instance->lazyObjectState)) {
            $instance->lazyObjectState->initializer = $initializer;
            unset($instance->lazyObjectState->realInstance);
            return $instance;
        }
        $instance->lazyObjectState = new LazyObjectState($initializer);
        foreach (Registry::$classResetters[$class] as $reset) {
            $reset($instance, $skippedProperties = $skippedProperties ?? []);
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
        return !isset($this->lazyObjectState) || isset($this->lazyObjectState->realInstance) || Registry::$noInitializerState === $this->lazyObjectState->initializer;
    }
    /**
     * Forces initialization of a lazy object and returns it.
     */
    public function initializeLazyObject() : parent
    {
        if ($state = $this->lazyObjectState ?? null) {
            return $state->realInstance = $state->realInstance ?? ($state->initializer)();
        }
        return $this;
    }
    /**
     * @return bool Returns false when the object cannot be reset, ie when it's not a lazy object
     */
    public function resetLazyObject() : bool
    {
        if (!isset($this->lazyObjectState) || Registry::$noInitializerState === $this->lazyObjectState->initializer) {
            return \false;
        }
        unset($this->lazyObjectState->realInstance);
        return \true;
    }
    /**
     * @return mixed
     */
    public function &__get($name)
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        $instance = $this;
        $notByRef = 0;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $notByRef = $access & Hydrator::PROPERTY_NOT_BY_REF;
            $scope = Registry::getScopeForRead($propertyScopes, $class, $name);
            if (null === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) {
                if ($state = $this->lazyObjectState ?? null) {
                    $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
                }
                if (\PHP_VERSION_ID >= 80400 && !$notByRef && $access >> 2 & \ReflectionProperty::IS_PRIVATE_SET) {
                    $scope = $scope ?? $writeScope;
                }
                $parent = 2;
                goto get_in_scope;
            }
        }
        $parent = (Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['get'];
        if ($state = $this->lazyObjectState ?? null) {
            $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
        } else {
            if (2 === $parent) {
                return parent::__get($name);
            }
            $value = parent::__get($name);
            return $value;
        }
        if (!$parent && null === $class && !\array_key_exists($name, (array) $instance)) {
            $frame = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            \trigger_error(\sprintf('Undefined property: %s::$%s in %s on line %s', \get_class($instance), $name, $frame['file'], $frame['line']), \E_USER_NOTICE);
        }
        get_in_scope:
        $notByRef = $notByRef || 1 === $parent;
        try {
            if (null === $scope) {
                if (!$notByRef) {
                    return $instance->{$name};
                }
                $value = $instance->{$name};
                return $value;
            }
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            return $accessor['get']($instance, $name, $notByRef);
        } catch (\Error $e) {
            if (\Error::class !== \get_class($e) || \strncmp($e->getMessage(), 'Cannot access uninitialized non-nullable property', \strlen('Cannot access uninitialized non-nullable property')) !== 0) {
                throw $e;
            }
            try {
                if (null === $scope) {
                    $instance->{$name} = [];
                    return $instance->{$name};
                }
                $accessor['set']($instance, $name, []);
                return $accessor['get']($instance, $name, $notByRef);
            } catch (\Error $exception) {
                throw $e;
            }
        }
    }
    public function __set($name, $value) : void
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        $instance = $this;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForWrite($propertyScopes, $class, $name, $access >> 2);
            if ($writeScope === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) {
                if ($state = $this->lazyObjectState ?? null) {
                    $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
                }
                goto set_in_scope;
            }
        }
        if ($state = $this->lazyObjectState ?? null) {
            $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
        } elseif ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['set']) {
            parent::__set($name, $value);
            return;
        }
        set_in_scope:
        if (null === $scope) {
            $instance->{$name} = $value;
        } else {
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            $accessor['set']($instance, $name, $value);
        }
    }
    public function __isset($name) : bool
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        $instance = $this;
        if ([$class] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForRead($propertyScopes, $class, $name);
            if (null === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) {
                if ($state = $this->lazyObjectState ?? null) {
                    $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
                }
                goto isset_in_scope;
            }
        }
        if ($state = $this->lazyObjectState ?? null) {
            $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
        } elseif ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['isset']) {
            return parent::__isset($name);
        }
        isset_in_scope:
        if (null === $scope) {
            return isset($instance->{$name});
        }
        $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
        return $accessor['isset']($instance, $name);
    }
    public function __unset($name) : void
    {
        $propertyScopes = Hydrator::$propertyScopes[\get_class($this)] = Hydrator::$propertyScopes[\get_class($this)] ?? Hydrator::getPropertyScopes(\get_class($this));
        $scope = null;
        $instance = $this;
        if ([$class, , $writeScope, $access] = $propertyScopes[$name] ?? null) {
            $scope = Registry::getScopeForWrite($propertyScopes, $class, $name, $access >> 2);
            if ($writeScope === $scope || isset($propertyScopes["\x00{$scope}\x00{$name}"])) {
                if ($state = $this->lazyObjectState ?? null) {
                    $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
                }
                goto unset_in_scope;
            }
        }
        if ($state = $this->lazyObjectState ?? null) {
            $instance = $state->realInstance = $state->realInstance ?? ($state->initializer)();
        } elseif ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['unset']) {
            parent::__unset($name);
            return;
        }
        unset_in_scope:
        if (null === $scope) {
            unset($instance->{$name});
        } else {
            $accessor = Registry::$classAccessors[$scope] = Registry::$classAccessors[$scope] ?? Registry::getClassAccessors($scope);
            $accessor['unset']($instance, $name);
        }
    }
    public function __clone()
    {
        if (!isset($this->lazyObjectState)) {
            if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['clone']) {
                parent::__clone();
            }
            return;
        }
        $this->lazyObjectState = clone $this->lazyObjectState;
    }
    public function __serialize() : array
    {
        $class = self::class;
        $state = $this->lazyObjectState ?? null;
        if (!$state && (Registry::$parentMethods[$class] = Registry::$parentMethods[$class] ?? Registry::getParentMethods($class))['serialize']) {
            $properties = parent::__serialize();
        } else {
            $properties = (array) $this;
            if ($state) {
                unset($properties["\x00{$class}\x00lazyObjectState"]);
                $properties["\x00{$class}\x00lazyObjectReal"] = $state->realInstance = $state->realInstance ?? ($state->initializer)();
            }
        }
        if ($state || Registry::$parentMethods[$class]['serialize'] || !Registry::$parentMethods[$class]['sleep']) {
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
    public function __unserialize(array $data) : void
    {
        $class = self::class;
        if ($instance = $data["\x00{$class}\x00lazyObjectReal"] ?? null) {
            unset($data["\x00{$class}\x00lazyObjectReal"]);
            foreach (Registry::$classResetters[$class] = Registry::$classResetters[$class] ?? Registry::getClassResetters($class) as $reset) {
                $reset($this, $data);
            }
            if ($data) {
                PublicHydrator::hydrate($this, $data);
            }
            $this->lazyObjectState = new LazyObjectState(Registry::$noInitializerState = Registry::$noInitializerState ?? static function () {
                throw new \LogicException('Lazy proxy has no initializer.');
            });
            $this->lazyObjectState->realInstance = $instance;
        } elseif ((Registry::$parentMethods[$class] = Registry::$parentMethods[$class] ?? Registry::getParentMethods($class))['unserialize']) {
            parent::__unserialize($data);
        } else {
            PublicHydrator::hydrate($this, $data);
            if (Registry::$parentMethods[$class]['wakeup']) {
                parent::__wakeup();
            }
        }
    }
    public function __destruct()
    {
        if (isset($this->lazyObjectState)) {
            return;
        }
        if ((Registry::$parentMethods[self::class] = Registry::$parentMethods[self::class] ?? Registry::getParentMethods(self::class))['destruct']) {
            parent::__destruct();
        }
    }
}
