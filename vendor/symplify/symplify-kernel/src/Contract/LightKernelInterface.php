<?php

declare (strict_types=1);
namespace ConfigTransformer202201156\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202201156\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202201156\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202201156\Psr\Container\ContainerInterface;
}
