<?php

declare (strict_types=1);
namespace ConfigTransformer202207\Symplify\EasyTesting\Kernel;

use ConfigTransformer202207\Psr\Container\ContainerInterface;
use ConfigTransformer202207\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer202207\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
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
