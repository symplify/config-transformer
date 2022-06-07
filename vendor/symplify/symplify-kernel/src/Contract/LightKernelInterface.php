<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202206079\Psr\Container\ContainerInterface;
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
