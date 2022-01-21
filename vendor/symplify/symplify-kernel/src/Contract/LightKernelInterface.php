<?php

declare (strict_types=1);
namespace ConfigTransformer202201211\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202201211\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202201211\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202201211\Psr\Container\ContainerInterface;
}
