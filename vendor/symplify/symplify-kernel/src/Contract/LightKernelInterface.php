<?php

declare (strict_types=1);
namespace ConfigTransformer202201302\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202201302\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202201302\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202201302\Psr\Container\ContainerInterface;
}
