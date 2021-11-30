<?php

declare (strict_types=1);
namespace ConfigTransformer202111301\Symplify\EasyTesting\Kernel;

use ConfigTransformer202111301\Psr\Container\ContainerInterface;
use ConfigTransformer202111301\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202111301\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202111301\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111301\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer202111301\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
