<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\SymplifyKernel\Contract;

use ConfigTransformer20220607\Psr\Container\ContainerInterface;
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
