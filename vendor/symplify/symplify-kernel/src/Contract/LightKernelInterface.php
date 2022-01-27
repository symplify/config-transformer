<?php

declare (strict_types=1);
namespace ConfigTransformer202201274\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202201274\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202201274\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202201274\Psr\Container\ContainerInterface;
}
