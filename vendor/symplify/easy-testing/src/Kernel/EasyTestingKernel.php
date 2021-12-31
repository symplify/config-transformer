<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\EasyTesting\Kernel;

use ConfigTransformer2021123110\Psr\Container\ContainerInterface;
use ConfigTransformer2021123110\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2021123110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2021123110\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer2021123110\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
