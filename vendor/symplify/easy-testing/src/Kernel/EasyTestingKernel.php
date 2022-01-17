<?php

declare (strict_types=1);
namespace ConfigTransformer202201179\Symplify\EasyTesting\Kernel;

use ConfigTransformer202201179\Psr\Container\ContainerInterface;
use ConfigTransformer202201179\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202201179\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202201179\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202201179\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer202201179\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
