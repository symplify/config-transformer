<?php

declare (strict_types=1);
namespace ConfigTransformer202111192\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202111192\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111192\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202111192\Psr\Container\ContainerInterface;
}
