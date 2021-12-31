<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2021123110\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2021123110\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2021123110\Psr\Container\ContainerInterface;
}
