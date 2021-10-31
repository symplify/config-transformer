<?php

declare (strict_types=1);
namespace ConfigTransformer202110318\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202110318\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202110318\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202110318\Psr\Container\ContainerInterface;
}
