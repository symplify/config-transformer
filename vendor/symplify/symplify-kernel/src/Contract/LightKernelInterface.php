<?php

declare (strict_types=1);
namespace ConfigTransformer202203051\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202203051\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202203051\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202203051\Psr\Container\ContainerInterface;
}
