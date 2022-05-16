<?php

declare (strict_types=1);
namespace ConfigTransformer202205168\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202205168\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202205168\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202205168\Psr\Container\ContainerInterface;
}
