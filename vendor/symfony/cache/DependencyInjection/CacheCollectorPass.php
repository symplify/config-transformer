<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021101210\Symfony\Component\Cache\DependencyInjection;

use ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TraceableAdapter;
use ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Reference;
/**
 * Inject a data collector to all the cache services to be able to get detailed statistics.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheCollectorPass implements \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $dataCollectorCacheId;
    private $cachePoolTag;
    private $cachePoolRecorderInnerSuffix;
    public function __construct(string $dataCollectorCacheId = 'data_collector.cache', string $cachePoolTag = 'cache.pool', string $cachePoolRecorderInnerSuffix = '.recorder_inner')
    {
        if (0 < \func_num_args()) {
            trigger_deprecation('symfony/cache', '5.3', 'Configuring "%s" is deprecated.', __CLASS__);
        }
        $this->dataCollectorCacheId = $dataCollectorCacheId;
        $this->cachePoolTag = $cachePoolTag;
        $this->cachePoolRecorderInnerSuffix = $cachePoolRecorderInnerSuffix;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\ConfigTransformer2021101210\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->dataCollectorCacheId)) {
            return;
        }
        foreach ($container->findTaggedServiceIds($this->cachePoolTag) as $id => $attributes) {
            $poolName = $attributes[0]['name'] ?? $id;
            $this->addToCollector($id, $poolName, $container);
        }
    }
    private function addToCollector(string $id, string $name, \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $definition = $container->getDefinition($id);
        if ($definition->isAbstract()) {
            return;
        }
        $collectorDefinition = $container->getDefinition($this->dataCollectorCacheId);
        $recorder = new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Definition(\is_subclass_of($definition->getClass(), \ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class) ? \ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter::class : \ConfigTransformer2021101210\Symfony\Component\Cache\Adapter\TraceableAdapter::class);
        $recorder->setTags($definition->getTags());
        if (!$definition->isPublic() || !$definition->isPrivate()) {
            $recorder->setPublic($definition->isPublic());
        }
        $recorder->setArguments([new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Reference($innerId = $id . $this->cachePoolRecorderInnerSuffix)]);
        foreach ($definition->getMethodCalls() as [$method, $args]) {
            if ('setCallbackWrapper' !== $method || !$args[0] instanceof \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Definition || !($args[0]->getArguments()[2] ?? null) instanceof \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Definition) {
                continue;
            }
            if ([new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Reference($id), 'setCallbackWrapper'] == $args[0]->getArguments()[2]->getFactory()) {
                $args[0]->getArguments()[2]->setFactory([new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Reference($innerId), 'setCallbackWrapper']);
            }
        }
        $definition->setTags([]);
        $definition->setPublic(\false);
        $container->setDefinition($innerId, $definition);
        $container->setDefinition($id, $recorder);
        // Tell the collector to add the new instance
        $collectorDefinition->addMethodCall('addInstance', [$name, new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Reference($id)]);
        $collectorDefinition->setPublic(\false);
    }
}
