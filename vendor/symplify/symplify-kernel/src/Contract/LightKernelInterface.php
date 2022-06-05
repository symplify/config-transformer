<?php

declare (strict_types=1);
namespace ConfigTransformer202206056\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202206056\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202206056\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202206056\Psr\Container\ContainerInterface;
}
