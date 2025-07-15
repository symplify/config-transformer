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

use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Exception\LogicException;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\Hydrator;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyDecoratorTrait;
use ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal\LazyObjectRegistry;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class ProxyHelper
{
    /**
     * Helps generate lazy-loading ghost objects.
     *
     * @deprecated since Symfony 7.3, use native lazy objects instead
     *
     * @throws LogicException When the class is incompatible with ghost objects
     */
    public static function generateLazyGhost(\ReflectionClass $class) : string
    {
        if (\PHP_VERSION_ID >= 80400) {
            trigger_deprecation('symfony/var-exporter', '7.3', 'Using ProxyHelper::generateLazyGhost() is deprecated, use native lazy objects instead.');
        }
        if (\PHP_VERSION_ID < 80300 && $class->isReadOnly()) {
            throw new LogicException(\sprintf('Cannot generate lazy ghost with PHP < 8.3: class "%s" is readonly.', $class->name));
        }
        if ($class->isFinal()) {
            throw new LogicException(\sprintf('Cannot generate lazy ghost: class "%s" is final.', $class->name));
        }
        if ($class->isInterface() || $class->isAbstract() || $class->isTrait()) {
            throw new LogicException(\sprintf('Cannot generate lazy ghost: "%s" is not a concrete class.', $class->name));
        }
        if (\stdClass::class !== $class->name && $class->isInternal()) {
            throw new LogicException(\sprintf('Cannot generate lazy ghost: class "%s" is internal.', $class->name));
        }
        if ($class->hasMethod('__get') && 'mixed' !== (self::exportType($class->getMethod('__get')) ?? 'mixed')) {
            throw new LogicException(\sprintf('Cannot generate lazy ghost: return type of method "%s::__get()" should be "mixed".', $class->name));
        }
        static $traitMethods;
        $traitMethods = $traitMethods ?? (new \ReflectionClass(LazyGhostTrait::class))->getMethods();
        foreach ($traitMethods as $method) {
            if ($class->hasMethod($method->name) && $class->getMethod($method->name)->isFinal()) {
                throw new LogicException(\sprintf('Cannot generate lazy ghost: method "%s::%s()" is final.', $class->name, $method->name));
            }
        }
        $parent = $class;
        while ($parent = $parent->getParentClass()) {
            if (\stdClass::class !== $parent->name && $parent->isInternal()) {
                throw new LogicException(\sprintf('Cannot generate lazy ghost: class "%s" extends "%s" which is internal.', $class->name, $parent->name));
            }
        }
        $hooks = '';
        $propertyScopes = Hydrator::$propertyScopes[$class->name] = Hydrator::$propertyScopes[$class->name] ?? Hydrator::getPropertyScopes($class->name);
        foreach ($propertyScopes as $key => [$scope, $name, , $access]) {
            $propertyScopes[$k = "\x00{$scope}\x00{$name}"] ?? $propertyScopes[$k = "\x00*\x00{$name}"] ?? ($k = $name);
            $flags = $access >> 2;
            if ($k !== $key || !($access & Hydrator::PROPERTY_HAS_HOOKS) || $flags & \ReflectionProperty::IS_VIRTUAL) {
                continue;
            }
            if ($flags & (\ReflectionProperty::IS_FINAL | \ReflectionProperty::IS_PRIVATE)) {
                throw new LogicException(\sprintf('Cannot generate lazy ghost: property "%s::$%s" is final or private(set).', $class->name, $name));
            }
            $p = $propertyScopes[$k][4] ?? (Hydrator::$propertyScopes[$class->name][$k][4] = new \ReflectionProperty($scope, $name));
            $type = self::exportType($p);
            $hooks .= "\n    " . ($p->isProtected() ? 'protected' : 'public') . ($p->isProtectedSet() ? ' protected(set)' : '') . " {$type} \${$name}" . ($p->hasDefaultValue() ? ' = ' . VarExporter::export($p->getDefaultValue()) : '') . " {\n";
            foreach ($p->getHooks() as $hook => $method) {
                if ('get' === $hook) {
                    $ref = $method->returnsReference() ? '&' : '';
                    $hooks .= "        {$ref}get { \$this->initializeLazyObject(); return parent::\${$name}::get(); }\n";
                } elseif ('set' === $hook) {
                    $parameters = self::exportParameters($method, \true);
                    $arg = '$' . $method->getParameters()[0]->name;
                    $hooks .= "        set({$parameters}) { \$this->initializeLazyObject(); parent::\${$name}::set({$arg}); }\n";
                } else {
                    throw new LogicException(\sprintf('Cannot generate lazy ghost: hook "%s::%s()" is not supported.', $class->name, $method->name));
                }
            }
            $hooks .= "    }\n";
        }
        $propertyScopes = self::exportPropertyScopes($class->name, $propertyScopes);
        return <<<EOPHP
extends \\{$class->name} implements \\Symfony\\Component\\VarExporter\\LazyObjectInterface
{
use \\Symfony\\Component\\VarExporter\\LazyGhostTrait;

private const LAZY_OBJECT_PROPERTY_SCOPES = {$propertyScopes};
{$hooks}}

// Help opcache.preload discover always-needed symbols
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\Hydrator::class);
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\LazyObjectRegistry::class);
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\LazyObjectState::class);

EOPHP;
    }
    /**
     * Helps generate lazy-loading decorators.
     *
     * @param \ReflectionClass[] $interfaces
     *
     * @throws LogicException When the class is incompatible with virtual proxies
     */
    public static function generateLazyProxy(?\ReflectionClass $class, array $interfaces = []) : string
    {
        if (!\class_exists((($nullsafeVariable1 = $class) ? $nullsafeVariable1->name : null) ?? \stdClass::class, \false)) {
            throw new LogicException(\sprintf('Cannot generate lazy proxy: "%s" is not a class.', $class->name));
        }
        if (($nullsafeVariable2 = $class) ? $nullsafeVariable2->isFinal() : null) {
            throw new LogicException(\sprintf('Cannot generate lazy proxy: class "%s" is final.', $class->name));
        }
        if (\PHP_VERSION_ID < 80400) {
            return self::generateLegacyLazyProxy($class, $interfaces);
        }
        if ($class && !$class->isAbstract()) {
            $parent = $class;
            do {
                $extendsInternalClass = $parent->isInternal();
            } while (!$extendsInternalClass && ($parent = $parent->getParentClass()));
            if (!$extendsInternalClass) {
                trigger_deprecation('symfony/var-exporter', '7.3', 'Generating lazy proxy for class "%s" is deprecated; leverage native lazy objects instead.', $class->name);
                // throw new LogicException(\sprintf('Cannot generate lazy proxy: leverage native lazy objects instead for class "%s".', $class->name));
            }
        }
        $propertyScopes = $class ? Hydrator::$propertyScopes[$class->name] = Hydrator::$propertyScopes[$class->name] ?? Hydrator::getPropertyScopes($class->name) : [];
        $abstractProperties = [];
        $hookedProperties = [];
        foreach ($propertyScopes as $key => [$scope, $name, , $access]) {
            $propertyScopes[$k = "\x00{$scope}\x00{$name}"] ?? $propertyScopes[$k = "\x00*\x00{$name}"] ?? ($k = $name);
            $flags = $access >> 2;
            if ($k !== $key || $flags & \ReflectionProperty::IS_PRIVATE) {
                continue;
            }
            if ($flags & \ReflectionProperty::IS_ABSTRACT) {
                $abstractProperties[$name] = $propertyScopes[$k][4] ?? (Hydrator::$propertyScopes[$class->name][$k][4] = new \ReflectionProperty($scope, $name));
                continue;
            }
            $abstractProperties[$name] = \false;
            if (!($access & Hydrator::PROPERTY_HAS_HOOKS)) {
                continue;
            }
            if ($flags & \ReflectionProperty::IS_FINAL) {
                throw new LogicException(\sprintf('Cannot generate lazy proxy: property "%s::$%s" is final.', $class->name, $name));
            }
            $p = $propertyScopes[$k][4] ?? (Hydrator::$propertyScopes[$class->name][$k][4] = new \ReflectionProperty($scope, $name));
            $hookedProperties[$name] = [$p, $p->getHooks()];
        }
        $methodReflectors = [(($nullsafeVariable3 = $class) ? $nullsafeVariable3->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED) : null) ?? []];
        foreach ($interfaces as $interface) {
            if (!$interface->isInterface()) {
                throw new LogicException(\sprintf('Cannot generate lazy proxy: "%s" is not an interface.', $interface->name));
            }
            $methodReflectors[] = $interface->getMethods();
            foreach ($interface->getProperties() as $p) {
                $abstractProperties[$p->name] = $abstractProperties[$p->name] ?? $p;
                $hookedProperties[$p->name] = $hookedProperties[$p->name] ?? [$p, []];
                $hookedProperties[$p->name][1] += $p->getHooks();
            }
        }
        $hooks = '';
        foreach (\array_filter($abstractProperties) as $name => $p) {
            $type = self::exportType($p);
            $hooks .= "\n    " . ($p->isProtected() ? 'protected' : 'public') . ($p->isProtectedSet() ? ' protected(set)' : '') . " {$type} \${$name};\n";
        }
        foreach ($hookedProperties as $name => [$p, $methods]) {
            if ($abstractProperties[$p->name] ?? \false) {
                continue;
            }
            $type = self::exportType($p);
            $hooks .= "\n    " . ($p->isProtected() ? 'protected' : 'public') . ($p->isProtectedSet() ? ' protected(set)' : '') . " {$type} \${$name} {\n";
            foreach ($methods as $hook => $method) {
                if ('get' === $hook) {
                    $ref = $method->returnsReference() ? '&' : '';
                    $hooks .= <<<EOPHP
{$ref}get {
return \$this->lazyObjectState->realInstance->{$p->name};
}

EOPHP;
                } elseif ('set' === $hook) {
                    $parameters = self::exportParameters($method, \true);
                    $arg = '$' . $method->getParameters()[0]->name;
                    $hooks .= <<<EOPHP
set({$parameters}) {
\$this->lazyObjectState->realInstance->{$p->name} = {$arg};
}

EOPHP;
                } else {
                    throw new LogicException(\sprintf('Cannot generate lazy proxy: hook "%s::%s()" is not supported.', $class->name, $method->name));
                }
            }
            $hooks .= "    }\n";
        }
        $methods = [];
        $methodReflectors = \array_merge(...$methodReflectors);
        foreach ($methodReflectors as $method) {
            if ('__get' !== \strtolower($method->name) || 'mixed' === ($type = self::exportType($method) ?? 'mixed')) {
                continue;
            }
            $trait = new \ReflectionMethod(LazyDecoratorTrait::class, '__get');
            $body = \array_slice(\file($trait->getFileName()), $trait->getStartLine() - 1, $trait->getEndLine() - $trait->getStartLine());
            $body[0] = \str_replace('): mixed', '): ' . $type, $body[0]);
            $methods['__get'] = \strtr(\implode('', $body) . '    }', ['Hydrator' => '\\' . Hydrator::class, 'Registry' => '\\' . LazyObjectRegistry::class]);
            break;
        }
        foreach ($methodReflectors as $method) {
            if ($method->isStatic() && !$method->isAbstract() || isset($methods[$lcName = \strtolower($method->name)])) {
                continue;
            }
            if ($method->isFinal()) {
                throw new LogicException(\sprintf('Cannot generate lazy proxy: method "%s::%s()" is final.', $class->name, $method->name));
            }
            if (\method_exists(LazyDecoratorTrait::class, $method->name)) {
                continue;
            }
            $signature = self::exportSignature($method, \true, $args);
            if ($method->isStatic()) {
                $body = "        throw new \\BadMethodCallException('Cannot forward abstract method \"{$method->class}::{$method->name}()\".');";
            } elseif (\substr_compare($signature, '): never', -\strlen('): never')) === 0 || \substr_compare($signature, '): void', -\strlen('): void')) === 0) {
                $body = <<<EOPHP
\$this->lazyObjectState->realInstance->{$method->name}({$args});
EOPHP;
            } else {
                $mayReturnThis = \false;
                foreach (\preg_split('/[()|&]++/', self::exportType($method) ?? 'static') as $type) {
                    if (\in_array($type = \ltrim($type, '?'), ['static', 'object'], \true)) {
                        $mayReturnThis = \true;
                        break;
                    }
                    foreach (\array_merge([$class], $interfaces) as $r) {
                        if ($r && \is_a($r->name, $type, \true)) {
                            $mayReturnThis = \true;
                            break 2;
                        }
                    }
                }
                if ($method->returnsReference() || !$mayReturnThis) {
                    $body = <<<EOPHP
return \$this->lazyObjectState->realInstance->{$method->name}({$args});
EOPHP;
                } else {
                    $body = <<<EOPHP
\${0} = \$this->lazyObjectState->realInstance;
\${1} = \${0}->{$method->name}({$args});

return match (true) {
\${1} === \${0} => \$this,
!\${1} instanceof \${0} || !\${0} instanceof \${1} => \${1},
null !== \$this->lazyObjectState->cloneInstance =& \${1} => clone \$this,
};
EOPHP;
                }
            }
            $methods[$lcName] = "    {$signature}\n    {\n{$body}\n    }";
        }
        $types = $interfaces = \array_unique(\array_column($interfaces, 'name'));
        $interfaces[] = LazyObjectInterface::class;
        $interfaces = \implode(', \\', $interfaces);
        $parent = $class ? ' extends \\' . $class->name : '';
        \array_unshift($types, $class ? 'parent' : '');
        $type = \ltrim(\implode('&\\', $types), '&');
        if (!$class) {
            $trait = new \ReflectionMethod(LazyDecoratorTrait::class, 'initializeLazyObject');
            $body = \array_slice(\file($trait->getFileName()), $trait->getStartLine() - 1, $trait->getEndLine() - $trait->getStartLine());
            $body[0] = \str_replace('): parent', '): ' . $type, $body[0]);
            $methods = ['initializeLazyObject' => \implode('', $body) . '    }'] + $methods;
        }
        $body = $methods ? "\n" . \implode("\n\n", $methods) . "\n" : '';
        $propertyScopes = $class ? self::exportPropertyScopes($class->name, $propertyScopes) : '[]';
        $lazyProxyTraitStatement = [];
        if ((($nullsafeVariable4 = $class) ? $nullsafeVariable4->hasMethod('__unserialize') : null) && !$class->getMethod('__unserialize')->getParameters()[0]->getType()) {
            // fix contravariance type problem when $class declares a `__unserialize()` method without typehint.
            $lazyProxyTraitStatement[] = '__unserialize as private __doUnserialize;';
            $body .= <<<EOPHP

public function __unserialize(\$data): void
{
\$this->__doUnserialize(\$data);
}

EOPHP;
        }
        if ($lazyProxyTraitStatement) {
            $lazyProxyTraitStatement = \implode("\n        ", $lazyProxyTraitStatement);
            $lazyProxyTraitStatement = <<<EOPHP
use \\Symfony\\Component\\VarExporter\\Internal\\LazyDecoratorTrait {
{$lazyProxyTraitStatement}
}
EOPHP;
        } else {
            $lazyProxyTraitStatement = <<<EOPHP
use \\Symfony\\Component\\VarExporter\\Internal\\LazyDecoratorTrait;
EOPHP;
        }
        return <<<EOPHP
{$parent} implements \\{$interfaces}
{
{$lazyProxyTraitStatement}

private const LAZY_OBJECT_PROPERTY_SCOPES = {$propertyScopes};
{$hooks}{$body}}

// Help opcache.preload discover always-needed symbols
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\Hydrator::class);
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\LazyObjectRegistry::class);

EOPHP;
    }
    private static function generateLegacyLazyProxy(?\ReflectionClass $class, array $interfaces) : string
    {
        if (\PHP_VERSION_ID < 80300 && (($nullsafeVariable5 = $class) ? $nullsafeVariable5->isReadOnly() : null)) {
            throw new LogicException(\sprintf('Cannot generate lazy proxy with PHP < 8.3: class "%s" is readonly.', $class->name));
        }
        $propertyScopes = $class ? Hydrator::$propertyScopes[$class->name] = Hydrator::$propertyScopes[$class->name] ?? Hydrator::getPropertyScopes($class->name) : [];
        $methodReflectors = [(($nullsafeVariable6 = $class) ? $nullsafeVariable6->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED) : null) ?? []];
        foreach ($interfaces as $interface) {
            if (!$interface->isInterface()) {
                throw new LogicException(\sprintf('Cannot generate lazy proxy: "%s" is not an interface.', $interface->name));
            }
            $methodReflectors[] = $interface->getMethods();
        }
        $extendsInternalClass = \false;
        if ($parent = $class) {
            do {
                $extendsInternalClass = \stdClass::class !== $parent->name && $parent->isInternal();
            } while (!$extendsInternalClass && ($parent = $parent->getParentClass()));
        }
        $methodsHaveToBeProxied = $extendsInternalClass;
        $methods = [];
        $methodReflectors = \array_merge(...$methodReflectors);
        foreach ($methodReflectors as $method) {
            if ('__get' !== \strtolower($method->name) || 'mixed' === ($type = self::exportType($method) ?? 'mixed')) {
                continue;
            }
            $methodsHaveToBeProxied = \true;
            $trait = new \ReflectionMethod(LazyProxyTrait::class, '__get');
            $body = \array_slice(\file($trait->getFileName()), $trait->getStartLine() - 1, $trait->getEndLine() - $trait->getStartLine());
            $body[0] = \str_replace('): mixed', '): ' . $type, $body[0]);
            $methods['__get'] = \strtr(\implode('', $body) . '    }', ['Hydrator' => '\\' . Hydrator::class, 'Registry' => '\\' . LazyObjectRegistry::class]);
            break;
        }
        foreach ($methodReflectors as $method) {
            if ($method->isStatic() && !$method->isAbstract() || isset($methods[$lcName = \strtolower($method->name)])) {
                continue;
            }
            if ($method->isFinal()) {
                if ($extendsInternalClass || $methodsHaveToBeProxied || \method_exists(LazyProxyTrait::class, $method->name)) {
                    throw new LogicException(\sprintf('Cannot generate lazy proxy: method "%s::%s()" is final.', $class->name, $method->name));
                }
                continue;
            }
            if (\method_exists(LazyProxyTrait::class, $method->name) || $method->isProtected() && !$method->isAbstract()) {
                continue;
            }
            $signature = self::exportSignature($method, \true, $args);
            $parentCall = $method->isAbstract() ? "throw new \\BadMethodCallException('Cannot forward abstract method \"{$method->class}::{$method->name}()\".')" : "parent::{$method->name}({$args})";
            if ($method->isStatic()) {
                $body = "        {$parentCall};";
            } elseif (\substr_compare($signature, '): never', -\strlen('): never')) === 0 || \substr_compare($signature, '): void', -\strlen('): void')) === 0) {
                $body = <<<EOPHP
if (isset(\$this->lazyObjectState)) {
(\$this->lazyObjectState->realInstance ??= (\$this->lazyObjectState->initializer)())->{$method->name}({$args});
} else {
{$parentCall};
}
EOPHP;
            } else {
                if (!$methodsHaveToBeProxied && !$method->isAbstract()) {
                    // Skip proxying methods that might return $this
                    foreach (\preg_split('/[()|&]++/', self::exportType($method) ?? 'static') as $type) {
                        if (\in_array($type = \ltrim($type, '?'), ['static', 'object'], \true)) {
                            continue 2;
                        }
                        foreach (\array_merge([$class], $interfaces) as $r) {
                            if ($r && \is_a($r->name, $type, \true)) {
                                continue 3;
                            }
                        }
                    }
                }
                $body = <<<EOPHP
if (isset(\$this->lazyObjectState)) {
return (\$this->lazyObjectState->realInstance ??= (\$this->lazyObjectState->initializer)())->{$method->name}({$args});
}

return {$parentCall};
EOPHP;
            }
            $methods[$lcName] = "    {$signature}\n    {\n{$body}\n    }";
        }
        $types = $interfaces = \array_unique(\array_column($interfaces, 'name'));
        $interfaces[] = LazyObjectInterface::class;
        $interfaces = \implode(', \\', $interfaces);
        $parent = $class ? ' extends \\' . $class->name : '';
        \array_unshift($types, $class ? 'parent' : '');
        $type = \ltrim(\implode('&\\', $types), '&');
        if (!$class) {
            $trait = new \ReflectionMethod(LazyProxyTrait::class, 'initializeLazyObject');
            $body = \array_slice(\file($trait->getFileName()), $trait->getStartLine() - 1, $trait->getEndLine() - $trait->getStartLine());
            $body[0] = \str_replace('): parent', '): ' . $type, $body[0]);
            $methods = ['initializeLazyObject' => \implode('', $body) . '    }'] + $methods;
        }
        $body = $methods ? "\n" . \implode("\n\n", $methods) . "\n" : '';
        $propertyScopes = $class ? self::exportPropertyScopes($class->name, $propertyScopes) : '[]';
        if ((($nullsafeVariable7 = $class) ? $nullsafeVariable7->hasMethod('__unserialize') : null) && !$class->getMethod('__unserialize')->getParameters()[0]->getType()) {
            // fix contravariance type problem when $class declares a `__unserialize()` method without typehint.
            $lazyProxyTraitStatement = <<<EOPHP
use \\Symfony\\Component\\VarExporter\\LazyProxyTrait {
__unserialize as private __doUnserialize;
}
EOPHP;
            $body .= <<<EOPHP

public function __unserialize(\$data): void
{
\$this->__doUnserialize(\$data);
}

EOPHP;
        } else {
            $lazyProxyTraitStatement = <<<EOPHP
use \\Symfony\\Component\\VarExporter\\LazyProxyTrait;
EOPHP;
        }
        return <<<EOPHP
{$parent} implements \\{$interfaces}
{
{$lazyProxyTraitStatement}

private const LAZY_OBJECT_PROPERTY_SCOPES = {$propertyScopes};
{$body}}

// Help opcache.preload discover always-needed symbols
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\Hydrator::class);
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\LazyObjectRegistry::class);
class_exists(\\Symfony\\Component\\VarExporter\\Internal\\LazyObjectState::class);

EOPHP;
    }
    public static function exportParameters(\ReflectionFunctionAbstract $function, bool $withParameterTypes = \true, ?string &$args = null) : string
    {
        $byRefIndex = 0;
        $args = '';
        $param = null;
        $parameters = [];
        $namespace = $function instanceof \ReflectionMethod ? $function->class : $function->getNamespaceName() . '\\';
        $namespace = \substr($namespace, 0, \strrpos($namespace, '\\') ?: 0);
        foreach ($function->getParameters() as $param) {
            $parameters[] = ((\method_exists($param, 'getAttributes') ? $param->getAttributes(\ConfigTransformerPrefix202507\SensitiveParameter::class) : []) ? '#[\\SensitiveParameter] ' : '') . ($withParameterTypes && $param->hasType() ? self::exportType($param) . ' ' : '') . ($param->isPassedByReference() ? '&' : '') . ($param->isVariadic() ? '...' : '') . '$' . $param->name . ($param->isOptional() && !$param->isVariadic() ? ' = ' . self::exportDefault($param, $namespace) : '');
            if ($param->isPassedByReference()) {
                $byRefIndex = 1 + $param->getPosition();
            }
            $args .= ($param->isVariadic() ? '...$' : '$') . $param->name . ', ';
        }
        if (!$param || !$byRefIndex) {
            $args = '...\\func_get_args()';
        } elseif ($param->isVariadic()) {
            $args = \substr($args, 0, -2);
        } else {
            $args = \explode(', ', $args, 1 + $byRefIndex);
            $args[$byRefIndex] = \sprintf('...\\array_slice(\\func_get_args(), %d)', $byRefIndex);
            $args = \implode(', ', $args);
        }
        return \implode(', ', $parameters);
    }
    public static function exportSignature(\ReflectionFunctionAbstract $function, bool $withParameterTypes = \true, ?string &$args = null) : string
    {
        $parameters = self::exportParameters($function, $withParameterTypes, $args);
        $signature = 'function ' . ($function->returnsReference() ? '&' : '') . ($function->isClosure() ? '' : $function->name) . '(' . $parameters . ')';
        if ($function instanceof \ReflectionMethod) {
            $signature = ($function->isPublic() ? 'public ' : ($function->isProtected() ? 'protected ' : 'private ')) . ($function->isStatic() ? 'static ' : '') . $signature;
        }
        if ($function->hasReturnType()) {
            $signature .= ': ' . self::exportType($function);
        }
        static $getPrototype;
        $getPrototype = $getPrototype ?? \Closure::fromCallable([new \ReflectionMethod(\ReflectionMethod::class, 'getPrototype'), 'invoke']);
        while ($function) {
            if ($function->hasTentativeReturnType()) {
                return '#[\\ReturnTypeWillChange] ' . $signature;
            }
            try {
                $function = $function instanceof \ReflectionMethod && $function->isAbstract() ? \false : $getPrototype($function);
            } catch (\ReflectionException $exception) {
                break;
            }
        }
        return $signature;
    }
    /**
     * @param \ReflectionFunctionAbstract|\ReflectionProperty|\ReflectionParameter $owner
     */
    public static function exportType($owner, bool $noBuiltin = \false, ?\ReflectionType $type = null) : ?string
    {
        if (!($type = $type ?? $owner instanceof \ReflectionFunctionAbstract ? $owner->getReturnType() : $owner->getType())) {
            return null;
        }
        $class = null;
        $types = [];
        if ($type instanceof \ReflectionUnionType) {
            $reflectionTypes = $type->getTypes();
            $glue = '|';
        } elseif ($type instanceof \ReflectionIntersectionType) {
            $reflectionTypes = $type->getTypes();
            $glue = '&';
        } else {
            $reflectionTypes = [$type];
            $glue = null;
        }
        foreach ($reflectionTypes as $type) {
            if ($type instanceof \ReflectionIntersectionType) {
                if ('' !== ($name = '(' . self::exportType($owner, $noBuiltin, $type) . ')')) {
                    $types[] = $name;
                }
                continue;
            }
            $name = $type->getName();
            if ($noBuiltin && $type->isBuiltin()) {
                continue;
            }
            if (\in_array($name, ['parent', 'self'], \true) && ($class = $class ?? $owner->getDeclaringClass())) {
                $name = 'parent' === $name ? (($nullsafeVariable8 = $class->getParentClass() ?: null) ? $nullsafeVariable8->name : null) ?? 'parent' : $class->name;
            }
            $types[] = ($noBuiltin || $type->isBuiltin() || 'static' === $name ? '' : '\\') . $name;
        }
        if (!$types) {
            return '';
        }
        if (null === $glue) {
            return (!$noBuiltin && $type->allowsNull() && !\in_array($name, ['mixed', 'null'], \true) ? '?' : '') . $types[0];
        }
        \sort($types);
        return \implode($glue, $types);
    }
    private static function exportPropertyScopes(string $parent, array $propertyScopes) : string
    {
        \uksort($propertyScopes, 'strnatcmp');
        foreach ($propertyScopes as $k => $v) {
            unset($propertyScopes[$k][4]);
        }
        $propertyScopes = VarExporter::export($propertyScopes);
        $propertyScopes = \str_replace(VarExporter::export($parent), 'parent::class', $propertyScopes);
        $propertyScopes = \preg_replace("/(?|(,)\n( )       |\n        |,\n    (\\]))/", '$1$2', $propertyScopes);
        return \str_replace("\n", "\n    ", $propertyScopes);
    }
    private static function exportDefault(\ReflectionParameter $param, $namespace) : string
    {
        $default = \rtrim(\substr(\explode('$' . $param->name . ' = ', (string) $param, 2)[1] ?? '', 0, -2));
        if (\in_array($default, ['<default>', 'NULL'], \true)) {
            return 'null';
        }
        if (\substr_compare($default, "...'", -\strlen("...'")) === 0 && \preg_match("/^'(?:[^'\\\\]*+(?:\\\\.)*+)*+'\$/", $default)) {
            return VarExporter::export($param->getDefaultValue());
        }
        $regexp = "/(\"(?:[^\"\\\\]*+(?:\\\\.)*+)*+\"|'(?:[^'\\\\]*+(?:\\\\.)*+)*+')/";
        $parts = \preg_split($regexp, $default, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY);
        $regexp = '/([\\[\\( ]|^)([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*+(?:\\\\[a-zA-Z0-9_\\x7f-\\xff]++)*+)(\\(?)(?!: )/';
        switch ($m[2]) {
            case 'new':
            case 'false':
            case 'true':
            case 'null':
                $callback = $m[2];
                break;
            case 'NULL':
                $callback = 'null';
                break;
            case 'self':
                $callback = '\\' . $class->name;
                break;
            case 'namespace\\parent':
            case 'parent':
                $callback = ($parent = $class->getParentClass()) ? '\\' . $parent->name : 'parent';
                break;
            default:
                $callback = self::exportSymbol($m[2], '(' !== $m[3], $namespace);
                break;
        }
        return \implode('', \array_map(function ($part) use($regexp, $callback) {
            switch ($part[0]) {
                case '"':
                    return $part;
                case "'":
                    return \false !== \strpbrk($part, "\\\x00\r\n") ? '"' . \substr(\str_replace(['$', "\x00", "\r", "\n"], ['\\$', '\\0', '\\r', '\\n'], $part), 1, -1) . '"' : $part;
                default:
                    return \preg_replace_callback($regexp, $callback, $part);
            }
        }, $parts));
    }
    private static function exportSymbol(string $symbol, bool $mightBeRootConst, string $namespace) : string
    {
        if (!$mightBeRootConst || \false === ($ns = \strrpos($symbol, '\\')) || \substr($symbol, 0, $ns) !== $namespace || \defined($symbol) || !\defined(\substr($symbol, $ns + 1))) {
            return '\\' . $symbol;
        }
        return '\\' . \substr($symbol, $ns + 1);
    }
}
