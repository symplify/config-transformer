<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2022052410\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2022052410\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2022052410\Psr\Container\ContainerInterface;
}
