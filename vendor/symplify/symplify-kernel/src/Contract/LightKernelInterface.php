<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202205306\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202205306\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202205306\Psr\Container\ContainerInterface;
}
