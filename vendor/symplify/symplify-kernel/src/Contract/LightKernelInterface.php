<?php

declare (strict_types=1);
namespace ConfigTransformer202206019\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202206019\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202206019\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202206019\Psr\Container\ContainerInterface;
}
