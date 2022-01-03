<?php

declare (strict_types=1);
namespace ConfigTransformer2022010310\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2022010310\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2022010310\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer2022010310\Psr\Container\ContainerInterface;
}
