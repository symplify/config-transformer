<?php

declare (strict_types=1);
namespace ConfigTransformer202111216\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202111216\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111216\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202111216\Psr\Container\ContainerInterface;
}
