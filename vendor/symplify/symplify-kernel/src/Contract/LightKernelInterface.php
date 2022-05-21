<?php

declare (strict_types=1);
namespace ConfigTransformer202205218\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202205218\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202205218\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202205218\Psr\Container\ContainerInterface;
}
