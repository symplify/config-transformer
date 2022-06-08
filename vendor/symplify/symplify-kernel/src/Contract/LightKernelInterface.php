<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\SymplifyKernel\Contract;

use ConfigTransformer20220608\Psr\Container\ContainerInterface;
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
