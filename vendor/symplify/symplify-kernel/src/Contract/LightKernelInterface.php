<?php

declare (strict_types=1);
namespace ConfigTransformer202111061\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202111061\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111061\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202111061\Psr\Container\ContainerInterface;
}
