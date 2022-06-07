<?php

declare (strict_types=1);
namespace ConfigTransformer202206076\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202206076\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202206076\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202206076\Psr\Container\ContainerInterface;
}
