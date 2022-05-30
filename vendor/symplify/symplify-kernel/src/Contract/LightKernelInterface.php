<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2022053010\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2022053010\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2022053010\Psr\Container\ContainerInterface;
}
