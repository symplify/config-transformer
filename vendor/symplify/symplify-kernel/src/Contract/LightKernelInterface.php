<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2021113010\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer2021113010\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2021113010\Psr\Container\ContainerInterface;
}
