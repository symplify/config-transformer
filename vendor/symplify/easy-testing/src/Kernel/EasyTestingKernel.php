<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\Symplify\EasyTesting\Kernel;

use ConfigTransformer2021113010\Psr\Container\ContainerInterface;
use ConfigTransformer2021113010\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer2021113010\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2021113010\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer2021113010\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer2021113010\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
