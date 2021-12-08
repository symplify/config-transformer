<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler;

use ConfigTransformer202112088\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202112088\Symfony\Component\DependencyInjection\Exception\EnvParameterException;
/**
 * This class is used to remove circular dependencies between individual passes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Compiler
{
    /**
     * @var \Symfony\Component\DependencyInjection\Compiler\PassConfig
     */
    private $passConfig;
    /**
     * @var mixed[]
     */
    private $log = [];
    /**
     * @var \Symfony\Component\DependencyInjection\Compiler\ServiceReferenceGraph
     */
    private $serviceReferenceGraph;
    public function __construct()
    {
        $this->passConfig = new \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler\PassConfig();
        $this->serviceReferenceGraph = new \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler\ServiceReferenceGraph();
    }
    public function getPassConfig() : \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler\PassConfig
    {
        return $this->passConfig;
    }
    public function getServiceReferenceGraph() : \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler\ServiceReferenceGraph
    {
        return $this->serviceReferenceGraph;
    }
    /**
     * @param \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass
     * @param string $type
     * @param int $priority
     */
    public function addPass($pass, $type = \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Compiler\PassConfig::TYPE_BEFORE_OPTIMIZATION, $priority = 0)
    {
        $this->passConfig->addPass($pass, $type, $priority);
    }
    /**
     * @final
     * @param \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass
     * @param string $message
     */
    public function log($pass, $message)
    {
        if (\strpos($message, "\n") !== \false) {
            $message = \str_replace("\n", "\n" . \get_class($pass) . ': ', \trim($message));
        }
        $this->log[] = \get_class($pass) . ': ' . $message;
    }
    public function getLog() : array
    {
        return $this->log;
    }
    /**
     * Run the Compiler and process all Passes.
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function compile($container)
    {
        try {
            foreach ($this->passConfig->getPasses() as $pass) {
                $pass->process($container);
            }
        } catch (\Exception $e) {
            $usedEnvs = [];
            $prev = $e;
            do {
                $msg = $prev->getMessage();
                if ($msg !== ($resolvedMsg = $container->resolveEnvPlaceholders($msg, null, $usedEnvs))) {
                    $r = new \ReflectionProperty($prev, 'message');
                    $r->setAccessible(\true);
                    $r->setValue($prev, $resolvedMsg);
                }
            } while ($prev = $prev->getPrevious());
            if ($usedEnvs) {
                $e = new \ConfigTransformer202112088\Symfony\Component\DependencyInjection\Exception\EnvParameterException($usedEnvs, $e);
            }
            throw $e;
        } finally {
            $this->getServiceReferenceGraph()->clear();
        }
    }
}
