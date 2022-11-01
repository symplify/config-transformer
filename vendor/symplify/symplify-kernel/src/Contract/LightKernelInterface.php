<?php

declare (strict_types=1);
namespace ConfigTransformer202211\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202211\Psr\Container\ContainerInterface;
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
