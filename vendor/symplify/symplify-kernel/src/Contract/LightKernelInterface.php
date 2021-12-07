<?php

declare (strict_types=1);
namespace ConfigTransformer202112078\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202112078\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202112078\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202112078\Psr\Container\ContainerInterface;
}
