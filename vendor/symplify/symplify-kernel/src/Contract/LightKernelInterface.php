<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\SymplifyKernel\Contract;

use ConfigTransformer2022060710\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface;
    public function getContainer() : ContainerInterface;
}
