<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2021122310\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2021122310\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2021122310\Psr\Container\ContainerInterface;
}
