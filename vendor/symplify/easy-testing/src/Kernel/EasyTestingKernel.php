<?php

declare (strict_types=1);
namespace ConfigTransformer202206\Symplify\EasyTesting\Kernel;

use ConfigTransformer202206\Psr\Container\ContainerInterface;
use ConfigTransformer202206\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202206\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface
    {
        $configFiles[] = EasyTestingConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
