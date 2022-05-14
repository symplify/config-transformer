<?php

declare (strict_types=1);
namespace ConfigTransformer202205143\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202205143\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202205143\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202205143\Psr\Container\ContainerInterface;
}
