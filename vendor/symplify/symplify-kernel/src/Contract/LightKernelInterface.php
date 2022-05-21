<?php

declare (strict_types=1);
namespace ConfigTransformer202205215\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202205215\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202205215\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202205215\Psr\Container\ContainerInterface;
}
