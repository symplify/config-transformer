<?php

declare (strict_types=1);
namespace ConfigTransformer202111016\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202111016\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111016\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202111016\Psr\Container\ContainerInterface;
}
