<?php

declare (strict_types=1);
namespace ConfigTransformer202112071\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202112071\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202112071\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202112071\Psr\Container\ContainerInterface;
}
