<?php

declare (strict_types=1);
namespace ConfigTransformer202204161\Symplify\EasyTesting\Kernel;

use ConfigTransformer202204161\Psr\Container\ContainerInterface;
use ConfigTransformer202204161\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202204161\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202204161\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202204161\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer202204161\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
