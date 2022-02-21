<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202202215\Symfony\Component\Cache\DependencyInjection;

use ConfigTransformer202202215\Symfony\Component\Cache\Adapter\AbstractAdapter;
use ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ArrayAdapter;
use ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ChainAdapter;
use ConfigTransformer202202215\Symfony\Component\Cache\Adapter\NullAdapter;
use ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ParameterNormalizer;
use ConfigTransformer202202215\Symfony\Component\Cache\Messenger\EarlyExpirationDispatcher;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CachePoolPass implements \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\ConfigTransformer202202215\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if ($container->hasParameter('cache.prefix.seed')) {
            $seed = $container->getParameterBag()->resolveValue($container->getParameter('cache.prefix.seed'));
        } else {
            $seed = '_' . $container->getParameter('kernel.project_dir');
            $seed .= '.' . $container->getParameter('kernel.container_class');
        }
        $needsMessageHandler = \false;
        $allPools = [];
        $clearers = [];
        $attributes = ['provider', 'name', 'namespace', 'default_lifetime', 'early_expiration_message_bus', 'reset'];
        foreach ($container->findTaggedServiceIds('cache.pool') as $id => $tags) {
            $adapter = $pool = $container->getDefinition($id);
            if ($pool->isAbstract()) {
                continue;
            }
            $class = $adapter->getClass();
            while ($adapter instanceof \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition) {
                $adapter = $container->findDefinition($adapter->getParent());
                $class = $class ?: $adapter->getClass();
                if ($t = $adapter->getTag('cache.pool')) {
                    $tags[0] += $t[0];
                }
            }
            $name = $tags[0]['name'] ?? $id;
            if (!isset($tags[0]['namespace'])) {
                $namespaceSeed = $seed;
                if (null !== $class) {
                    $namespaceSeed .= '.' . $class;
                }
                $tags[0]['namespace'] = $this->getNamespace($namespaceSeed, $name);
            }
            if (isset($tags[0]['clearer'])) {
                $clearer = $tags[0]['clearer'];
                while ($container->hasAlias($clearer)) {
                    $clearer = (string) $container->getAlias($clearer);
                }
            } else {
                $clearer = null;
            }
            unset($tags[0]['clearer'], $tags[0]['name']);
            if (isset($tags[0]['provider'])) {
                $tags[0]['provider'] = new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference(static::getServiceProvider($container, $tags[0]['provider']));
            }
            if (\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ChainAdapter::class === $class) {
                $adapters = [];
                foreach ($adapter->getArgument(0) as $provider => $adapter) {
                    if ($adapter instanceof \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition) {
                        $chainedPool = $adapter;
                    } else {
                        $chainedPool = $adapter = new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition($adapter);
                    }
                    $chainedTags = [\is_int($provider) ? [] : ['provider' => $provider]];
                    $chainedClass = '';
                    while ($adapter instanceof \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition) {
                        $adapter = $container->findDefinition($adapter->getParent());
                        $chainedClass = $chainedClass ?: $adapter->getClass();
                        if ($t = $adapter->getTag('cache.pool')) {
                            $chainedTags[0] += $t[0];
                        }
                    }
                    if (\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ChainAdapter::class === $chainedClass) {
                        throw new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Invalid service "%s": chain of adapters cannot reference another chain, found "%s".', $id, $chainedPool->getParent()));
                    }
                    $i = 0;
                    if (isset($chainedTags[0]['provider'])) {
                        $chainedPool->replaceArgument($i++, new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference(static::getServiceProvider($container, $chainedTags[0]['provider'])));
                    }
                    if (isset($tags[0]['namespace']) && !\in_array($adapter->getClass(), [\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ArrayAdapter::class, \ConfigTransformer202202215\Symfony\Component\Cache\Adapter\NullAdapter::class], \true)) {
                        $chainedPool->replaceArgument($i++, $tags[0]['namespace']);
                    }
                    if (isset($tags[0]['default_lifetime'])) {
                        $chainedPool->replaceArgument($i++, $tags[0]['default_lifetime']);
                    }
                    $adapters[] = $chainedPool;
                }
                $pool->replaceArgument(0, $adapters);
                unset($tags[0]['provider'], $tags[0]['namespace']);
                $i = 1;
            } else {
                $i = 0;
            }
            foreach ($attributes as $attr) {
                if (!isset($tags[0][$attr])) {
                    // no-op
                } elseif ('reset' === $attr) {
                    if ($tags[0][$attr]) {
                        $pool->addTag('kernel.reset', ['method' => $tags[0][$attr]]);
                    }
                } elseif ('early_expiration_message_bus' === $attr) {
                    $needsMessageHandler = \true;
                    $pool->addMethodCall('setCallbackWrapper', [(new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Definition(\ConfigTransformer202202215\Symfony\Component\Cache\Messenger\EarlyExpirationDispatcher::class))->addArgument(new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference($tags[0]['early_expiration_message_bus']))->addArgument(new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference('reverse_container'))->addArgument((new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Definition('callable'))->setFactory([new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference($id), 'setCallbackWrapper'])->addArgument(null))]);
                    $pool->addTag('container.reversible');
                } elseif ('namespace' !== $attr || !\in_array($class, [\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ArrayAdapter::class, \ConfigTransformer202202215\Symfony\Component\Cache\Adapter\NullAdapter::class], \true)) {
                    $argument = $tags[0][$attr];
                    if ('default_lifetime' === $attr && !\is_numeric($argument)) {
                        $argument = (new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Definition('int', [$argument]))->setFactory([\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\ParameterNormalizer::class, 'normalizeDuration']);
                    }
                    $pool->replaceArgument($i++, $argument);
                }
                unset($tags[0][$attr]);
            }
            if (!empty($tags[0])) {
                throw new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Invalid "cache.pool" tag for service "%s": accepted attributes are "clearer", "provider", "name", "namespace", "default_lifetime", "early_expiration_message_bus" and "reset", found "%s".', $id, \implode('", "', \array_keys($tags[0]))));
            }
            if (null !== $clearer) {
                $clearers[$clearer][$name] = new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference($id, $container::IGNORE_ON_UNINITIALIZED_REFERENCE);
            }
            $allPools[$name] = new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Reference($id, $container::IGNORE_ON_UNINITIALIZED_REFERENCE);
        }
        if (!$needsMessageHandler) {
            $container->removeDefinition('cache.early_expiration_handler');
        }
        $notAliasedCacheClearerId = $aliasedCacheClearerId = 'cache.global_clearer';
        while ($container->hasAlias('cache.global_clearer')) {
            $aliasedCacheClearerId = (string) $container->getAlias('cache.global_clearer');
        }
        if ($container->hasDefinition($aliasedCacheClearerId)) {
            $clearers[$notAliasedCacheClearerId] = $allPools;
        }
        foreach ($clearers as $id => $pools) {
            $clearer = $container->getDefinition($id);
            if ($clearer instanceof \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ChildDefinition) {
                $clearer->replaceArgument(0, $pools);
            } else {
                $clearer->setArgument(0, $pools);
            }
            $clearer->addTag('cache.pool.clearer');
            if ('cache.system_clearer' === $id) {
                $clearer->addTag('kernel.cache_clearer');
            }
        }
        $allPoolsKeys = \array_keys($allPools);
        if ($container->hasDefinition('console.command.cache_pool_list')) {
            $container->getDefinition('console.command.cache_pool_list')->replaceArgument(0, $allPoolsKeys);
        }
        if ($container->hasDefinition('console.command.cache_pool_clear')) {
            $container->getDefinition('console.command.cache_pool_clear')->addArgument($allPoolsKeys);
        }
        if ($container->hasDefinition('console.command.cache_pool_delete')) {
            $container->getDefinition('console.command.cache_pool_delete')->addArgument($allPoolsKeys);
        }
    }
    private function getNamespace(string $seed, string $id)
    {
        return \substr(\str_replace('/', '-', \base64_encode(\hash('sha256', $id . $seed, \true))), 0, 10);
    }
    /**
     * @internal
     */
    public static function getServiceProvider(\ConfigTransformer202202215\Symfony\Component\DependencyInjection\ContainerBuilder $container, string $name)
    {
        $container->resolveEnvPlaceholders($name, null, $usedEnvs);
        if ($usedEnvs || \preg_match('#^[a-z]++:#', $name)) {
            $dsn = $name;
            if (!$container->hasDefinition($name = '.cache_connection.' . \ConfigTransformer202202215\Symfony\Component\DependencyInjection\ContainerBuilder::hash($dsn))) {
                $definition = new \ConfigTransformer202202215\Symfony\Component\DependencyInjection\Definition(\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\AbstractAdapter::class);
                $definition->setPublic(\false);
                $definition->setFactory([\ConfigTransformer202202215\Symfony\Component\Cache\Adapter\AbstractAdapter::class, 'createConnection']);
                $definition->setArguments([$dsn, ['lazy' => \true]]);
                $container->setDefinition($name, $definition);
            }
        }
        return $name;
    }
}
