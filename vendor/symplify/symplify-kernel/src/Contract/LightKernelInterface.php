<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202208\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface;
    public function getContainer() : ContainerInterface;
}
