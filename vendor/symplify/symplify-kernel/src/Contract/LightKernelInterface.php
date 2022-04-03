<?php

declare (strict_types=1);
namespace ConfigTransformer202204039\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202204039\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202204039\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202204039\Psr\Container\ContainerInterface;
}
