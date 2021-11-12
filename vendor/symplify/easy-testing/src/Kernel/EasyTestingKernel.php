<?php

declare (strict_types=1);
namespace ConfigTransformer202111123\Symplify\EasyTesting\Kernel;

use ConfigTransformer202111123\Psr\Container\ContainerInterface;
use ConfigTransformer202111123\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202111123\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202111123\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111123\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer202111123\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
