<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2021120410\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer2021120410\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2021120410\Psr\Container\ContainerInterface;
}
